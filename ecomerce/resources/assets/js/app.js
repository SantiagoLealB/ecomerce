
/**
 * First we will load all of this project"s JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

/*require("./bootstrap");
*/

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

/*Vue.component("example", require("./components/Example.vue"));

const app = new Vue({
    el: "#app"
});
*/

//configuaraion libreria para editar campos
$.fn.editable.defaults.mode = "inline"; //existe tambien el modal(ventanas modales)
$.fn.editable.defaults.ajaxOptions = {type: "PUT"}; //La ruta tipo Put

$(document).ready(function(){
	//campos a editar (estan en la vistaindex de orders)
	$(".set-guide-number").editable();

	$(".select-status").editable({
		source: [
			{value:"creado", text:"Creado"},
			{value:"enviado", text:"Enviado"},
			{value:"recibido", text:"Recibido"}
		]
	});


	console.log('holaaaa mmmm nnn mamamam');

	//para ajax
	$(".add-to-cart").on("submit", function(ev){
		ev.preventDefault();
		
		var form = $(this);
		var button = form.find("[type = 'submit']");
		
		//petición ajax(obtener los datos del form)
		$.ajax({
			url: form.attr("action"),
			method: form.attr("method"),
			data: form.serialize(),//datos codificados en Url
 
			//antes de que la petion ajax inicie
			beforeSend: function(){
				button.val("Cargando...");
			},
			//cuando el servidor responde la peation ajax
			success: function(data){
				button.css("background-color", "#00c853").val("Agregado");
				
				//console.log(data);
				//actualizar el contador del carrito

				$(".circle-shopping-cart").html(data.products_count).addClass("highlight");

				//restablecer boton despues de 2 segundo
				setTimeout(function(){
					restartButton(button);
				},3000);
			},
			//en caso de que la petión devueva error
			error: function(err){
				console.log(err);
				button.css("background-color", "#d50000").val("bbb Hubo un error");
			
				//restablecer boton despues de 2 segundo
				setTimeout(function(){
					restartButton(button);
				},3000);
			}
		});

		return false;
	});

	//volder el boton a su estado original
	function restartButton(button){
		button.val("agregar al carrito").attr("style", "");
		$(".circle-shopping-cart").removeClass("highlight");

	}
});