<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alerts extends Component
{
    protected $data;

    protected $type;
    protected $icon;
    protected $message;
    protected $title;
    protected $showMessage;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
        
        $this->parsing();
    }

    protected function parsing(){
        
		if($this->data->any()){
            $this->showMessage = true;
            $this->type = "danger";
            $this->icon = "ban";
            $this->title = "Terjadi Kesalahan.";

			foreach($this->data->all() as $row){
                $this->message .= "<li> $row </li>";
            }
			
			
		}

		if(session()->has('error')){
            $error = session('error');

            $this->showMessage = true;
            $this->type = "danger";
            $this->icon = "ban";
            $this->title = "Terjadi Kesalahan.";
            $this->message .= "<li> $error </li>";
		}

		if(session()->has('success')){
            $success = session('success');

            $this->showMessage = true;
            $this->type = "success";
            $this->icon = "check";
            $this->title = "Sukses.";
            $this->message .= "<li> $success </li>";
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        
        return view('components.alerts',[
            "showMessage" => $this->showMessage,
            "type" => $this->type,
            "icon" => $this->icon,
            "title" => $this->title,
            "message" => $this->message,
        ]);
    }
}
