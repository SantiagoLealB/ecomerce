<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	//ostrar los ultimos productos
	public function scopeLatest($query){
		return $query->orderBy('id', 'desc');
	}

    //enviar a paypal los productos que se venden
	public function paypalItem(){

		return \PayPalPayment::item()
			->setName($this->title)
			->setDescription($this->description)
			->setQuantity(1)
			->setPrice($this->pricing)
			->setCurrency('USD');//no estaba
	}
}
