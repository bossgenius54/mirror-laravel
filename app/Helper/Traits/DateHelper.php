<?php
namespace App\Helper\Traits;
use Jenssegers\Date\Date;


trait DateHelper {

    public function getCreatedCoolAttribute(){
        Date::setLocale('ru');
        $d = Date::createFromFormat('Y-m-d H:i:s', $this->created_at);

        return $d->diffForHumans();
    }

    public function getCreatedDateAttribute(){
        return $this->created_at->format('d.m.Y');
    }

    public function getDateBDefAttribute(){
        if (!$this->date_b)
            return '';

        Date::setLocale('ru');
        $d = Date::createFromFormat('Y-m-d', $this->date_b->format('Y-m-d'))->format('j F Y');
        
        return  $d;
    }

    public function getDateEDefAttribute(){
        if (!$this->date_e)
            return '';

        Date::setLocale('ru');
        $d = Date::createFromFormat('Y-m-d', $this->date_e->format('Y-m-d'))->format('j F Y');
        
        return  $d;
    }

    public function getCreatedFullAttribute(){
        return $this->created_at->format('d-m-Y H:i:s');
    }

    public function getCreatedAtAttribute($date){
        $d = Date::createFromFormat('Y-m-d H:i:s', $date);

        return $d->format('d.m.Y H:i:s');
    }

    public function getUpdatedAtAttribute($date){
        $d = Date::createFromFormat('Y-m-d H:i:s', $date);

        return $d->format('d.m.Y H:i:s');
    }

    public function getCreatedTimeAttribute(){
        return $this->created_at->format('h:i:s');
    }

    public function getUpdatedCoolAttribute(){
        Date::setLocale('ru');
        $d = Date::createFromFormat('Y-m-d H:i:s', $this->updated_at);

        return $d->diffForHumans();
    }

    public function getUpdatedDateAttribute(){
        return $this->updated_at->format('d-m-Y');
    }

    public function getUpdatedFullAttribute(){
        return $this->updated_at->format('d-m-Y H:i:s');
    }

    public function getUpdatedTimeAttribute(){
        return $this->updated_at->format('h:i:s');
    }

    
}

?>
