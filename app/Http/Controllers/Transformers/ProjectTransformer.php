<?php


namespace App\Http\Controllers\Transformers;


use App\Data\Models\Project;
use League\Fractal\TransformerAbstract;

class ProjectTransformer extends TransformerAbstract
{
    public $availableIncludes = ['user', 'church'];

    public function transform(Project $project)
    {
        return [
            'id' => $project->id,
            'project_name' => $project->project_name,
            'project_desc' => $project->project_desc,
            'project_status' => $project->project_status,
            'start' => $project->start,
            'end' => $project->end
        ];
    }

    public function includeUser(Project $project)
    {
        return $this->item($project->uploaded_by, new WorshipperTransformer());
    }

    public function includeChurch(Project $project)
    {
        return $this->item($project->church, new ChurchTransformer());
    }

}
