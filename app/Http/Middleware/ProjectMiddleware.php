<?php

namespace App\Http\Middleware;

use App\Models\project\Project;
use Closure;


class ProjectMiddleware
{
    /*
     _ Handle an incoming request.
     _
     _ @param  \Illuminate\Http\Request  $request
     _ @param  \Closure  $next
     _ @return mixed
     */
    public function handle($request, Closure $next, $guard = "crm")
    {
        $project = Project::find($request->project_id);
        $user_d = auth()->user();
        if ($project->creator->id == $user_d->id) {
            return $next($request);
        }

        if (@$project->users->find($user_d->id)->id and ($project->project_share == 3 or $project->project_share == 5)) {
            return $next($request);
        }

        return redirect(route('biller.projects.index'));

    }
}