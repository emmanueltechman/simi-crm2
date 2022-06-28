<?php

namespace App\Http\Requests\Focus\project;

use App\Models\project\Task;
use Illuminate\Foundation\Http\FormRequest;

class ManageTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
      if(access()->allow('task-manage')){
          return true;
      }
      if($this->id){
          $task=Task::find($this->id);
          if($task->creator_id == auth()->user()->id) return true;
          $assigned=$task->users->where('id','=',auth()->user()->id)->first();
          if(isset($assigned->id)){
              return true;
          }
      }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //Put your rules for the request in here
            //For Example : 'title' => 'required'
            //Further, see the documentation : https://laravel.com/docs/5.4/validation#creating-form-requests
        ];
    }

    public function messages()
    {
        return [
            //The Custom messages would go in here
            //For Example : 'title.required' => 'You need to fill in the title field.'
            //Further, see the documentation : https://laravel.com/docs/5.4/validation#customizing-the-error-messages
        ];
    }
}
