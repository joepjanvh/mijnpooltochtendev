<?php

namespace App\Exports;

use App\Models\Group;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Post;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HikePointsOverviewExport implements FromCollection, WithHeadings
{
    protected $hikeId;
    protected $posts;

    public function __construct($hikeId)
    {
        $this->hikeId = $hikeId;
        $this->posts = Post::where('hike_id', $this->hikeId)->get();
    }

    public function collection()
    {
        $groups = Group::where('hike_id', $this->hikeId)
            ->with(['posts' => function ($query) {
                $query->where('hike_id', $this->hikeId);
            }])
            ->get();

        $exportData = $groups->map(function ($group) {
            $totalPoints = 0;
            $pointsPerPost = [];

            foreach ($this->posts as $post) {
                $groupPost = $group->posts->find($post->id);

                if ($groupPost && $groupPost->pivot) {
                    $postPoints = ($groupPost->pivot->check_in_points ?? 0)
                        + ($groupPost->pivot->attitude_points ?? 0)
                        + ($groupPost->pivot->performance_points ?? 0);
                } else {
                    $postPoints = 0;
                }

                $pointsPerPost[] = $postPoints;
                $totalPoints += $postPoints;
            }

            // Zorg ervoor dat de data consistent is
            return collect(array_merge([
                $group->group_number,
                $group->group_name,
                $totalPoints
            ], $pointsPerPost));
        });

        return $exportData;
    }

    public function headings(): array
    {
        $headings = ['Koppel', 'Groepsnaam', 'Totaal'];

        foreach ($this->posts as $post) {
            $headings[] = "Post " . $post->id;
        }

        return $headings;
    }
}
