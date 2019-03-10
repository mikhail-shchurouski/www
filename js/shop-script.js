$(document).ready(function() {
    
     $("#newsticker").jCarouselLite({
		vertical: true,
		hoverPause:true,
		btnPrev: "#news-prev",
		btnNext: "#news-next",
		visible: 1,
		auto:3000,
		speed:500
	});
  
loadcart();// поднимаем функцию для обнавления строки о мини информации о товарах в корзине
itog_price();

$("#style-grid").click(function(){
    
$("#block-tovar-grid").show();  
$("#block-tovar-list").hide();      
$("#style-grid").attr("src","/img/grid-activ.jpg"); 
$("#style-list").attr("src","/img/list.jpg"); 
$.cookie('select_style','grid'); 
}); 

$("#style-list").click(function(){
    
$("#block-tovar-grid").hide();  
$("#block-tovar-list").show();  
$("#style-list").attr("src","/img/list-active.jpg"); 
$("#style-grid").attr("src","/img/grid.jpg"); 
$.cookie('select_style','list');   
});  

if ($.cookie('select_style') == 'grid') 
{
 $("#block-tovar-grid").show();  
$("#block-tovar-list").hide();  

$("#style-grid").attr("src","/img/grid-activ.jpg"); 
$("#style-list").attr("src","/img/list.jpg"); 
}
else 
{
 $("#block-tovar-grid").hide();  
$("#block-tovar-list").show();  
$("#style-list").attr("src","/img/list-active.jpg"); 
$("#style-grid").attr("src","/img/grid.jpg");    
} 

$("#select-sort").click(function(){
    
    $("#sorting-list").slideToggle(200);
});


$('block-category > ul > li > a').click(function(){                           
    
    if ($(this).attr('class') != 'active'){
        $('#block-category > ul > li > ul').slideUp(400);
        $(this).next().slideToggle(400);
        
           $('#block-category > ul > li >a').removeClass('active');
           $(this).addClass('active');
           $.cookie('select_cat',$(this).attr('id'));
        }
        else{
            $('#block-category > ul > li >a').removeClass('active');
            $('#block-category > ul > li >ul').slideUp(400);
            $.cookie('select_cat','');
        }

});
if ($.cookie('select_cat') != ''){
    
    $('#block-category > ul > li > #' + $.cookie('select_cat')).addClass('active').next().show();
}

$('#genpass').click(function(){   // отслеживаем нажатие на ссылку сгенерироать пароль в форме регистрации
    $.ajax({                      // запрос ajax  функция которая проверяет что ответил обработчик и пароль вставляет в ячейку
        type:"POST",
        url:"/functions/genpass.php",
        dataType:"html",
        cache:false,
        success:function(data){
            $('#reg_pass').val(data);
        }
    });
});

$('#reloadcaptcha').click(function(){   // обнавляем каптчу в поле регистрации
    $('#block-captcha > img').attr("src","/reg/reg_captcha.php?r="+ Math.random());
});

$('.top-auth').toggle(    // Обработчик кнопки вход для регистрации 
       function() {
           $(".top-auth").attr("id","active-button");
           $("#block-top-auth").fadeIn(400);  // появление формы плавное
       },
       function() {
           $(".top-auth").attr("id","");     // убираем id..
           $("#block-top-auth").fadeOut(200);  //плавно убираем форму после второго нажатия на кнопку Вход
       }
    );


$('#button-pass-show-hide').click(function(){    // скрыть или показать пароль в форме входа 
 var statuspass = $('#button-pass-show-hide').attr("class");   // определяем состояние иконки (по умолчанию глаз открыт))
  
    if (statuspass == "pass-show")
    {
       $('#button-pass-show-hide').attr("class","pass-hide");
       
     			            var $input = $("#auth_pass");      // 'эта функция открывает текст пароля'
			                var change = "text";
			                var rep = $("<input placeholder='Пароль' type='" + change + "' />")
			                    .attr("id", $input.attr("id"))
			                    .attr("name", $input.attr("name"))
			                    .attr('class', $input.attr('class'))
			                    .val($input.val())
			                    .insertBefore($input);
			                $input.remove();
			                $input = rep;
        
    }else
    {
        $('#button-pass-show-hide').attr("class","pass-show");
        
     			            var $input = $("#auth_pass");  // эта функция скрывает текст пароля
			                var change = "password";
			                var rep = $("<input placeholder='Пароль' type='" + change + "' />")
			                    .attr("id", $input.attr("id"))
			                    .attr("name", $input.attr("name"))
			                    .attr('class', $input.attr('class'))
			                    .val($input.val())
			                    .insertBefore($input);
			                $input.remove();
			                $input = rep;        
       
    }
  
  }); 
  
  
  
  
  
  
  

$("#button-auth").click(function() {                          // обработчик полей ввода для входа  в личный кабинет логин и пароль
        
 var auth_login = $("#auth_login").val();
 var auth_pass = $("#auth_pass").val();

 
 if (auth_login == "" || auth_login.length > 30 )             // проверяем пустое поле или нет и подсчитать длину строки
 {
    $("#auth_login").css("borderColor","#FDB6B6");             // если есть ошибка окрашиваем поле в красный цвет для вывода ошибки
    send_login = 'no';
 }else {
    
   $("#auth_login").css("borderColor","#DBDBDB");               // если все ок отправляем yes
   send_login = 'yes'; 
      }

 
if (auth_pass == "" || auth_pass.length > 15 )                 // все то же для пароля
 {
    $("#auth_pass").css("borderColor","#FDB6B6");
    send_pass = 'no';
 }else { $("#auth_pass").css("borderColor","#DBDBDB");  send_pass = 'yes'; }



 if ($("#rememberme").prop('checked'))                        // проверка чек бокса
 {
    auth_rememberme = 'yes';
                                                              // активен он или нет это чекбокс для формы вход
 }else { auth_rememberme = 'no'; }


 if ( send_login == 'yes' && send_pass == 'yes' )
 { 
  $("#button-auth").hide();                                  // убираем кнопку после нажатия для отправки]
  $(".auth-loading").show();
    
    $.ajax({                                                 // используем ajax для отправки данных из формы для входа и регистрации
  type: "POST",
  url: "/include/auth.php",
  data: "login="+auth_login+"&pass="+auth_pass+"&rememberme="+auth_rememberme,
  dataType: "html",
  cache: false,
  success: function(data) {

  if (data == 'yes_auth')                          // если регистрация успешна все супер
  {
      location.reload();                          
  }else                  
  {                                                     // в противном случае выводим сообщение логин или пароль не прав
      $("#message-auth").slideDown(400);
      $(".auth-loading").hide();
      $("#button-auth").show();
      
  }
  
}
});  
}
}); 


$('#remindpass').click(function(){                                  // открытие и закрытие формы для восстанавления пароля
    
			$('#input-email-pass').fadeOut(200, function() {  
            $('#block-remind').fadeIn(300);
			});
});

$('#prev-auth').click(function(){
    
			$('#block-remind').fadeOut(200, function() {  
            $('#input-email-pass').fadeIn(300);
			});
});


$('#button-remind').click(function(){                       // обработчик кнопки Готово для восстанавления пароля 
    
 var recall_email = $("#remind-email").val();
 
 if (recall_email == "" || recall_email.length > 20 )       // проверка корректности заполнения поля ввода емайла
 {
    $("#remind-email").css("borderColor","#FDB6B6");

 }else 
 {
   $("#remind-email").css("borderColor","#DBDBDB");
   
   $("#button-remind").hide();
   $(".auth-loading").show();
    
  $.ajax({                                                 // запрос обработчику - мы ему отправим наш емайл который ввел пользователь для восстановления пароля
  type: "POST",
  url: "/include/remind-pass.php",
  data: "email="+recall_email,
  dataType: "html",
  cache: false,
  success: function(data) {

  if (data == 'yes')
  {
     $(".auth-loading").hide();
     $("#button-remind").show();
     $('#message-remind').attr("class","message-remind-success").html("На ваш e-mail отправлен пароль.").slideDown(400);  // классы нужны для индинтификации обьекта и придания ему цвета
     
     setTimeout("$('#message-remind').html('').hide(),$('#block-remind').hide(),$('#input-email-pass').show()", 3000);  // через 3 секунды после отправленного пароля очищаем поля ввода, и скрываем блок для восстановления пароля и показываем форму для регистрации
 
  }else
  {
      $(".auth-loading").hide();
      $("#button-remind").show();
      $('#message-remind').attr("class","message-remind-error").html(data).slideDown(400);
      
  }
  }
}); 
  }
  }); 

 $('#auth-user-info').toggle(                          // открыть или закрыть форму профиль и выход из профиля
       function() {
           $("#block-user").fadeIn(100);
       },
       function() {
           $("#block-user").fadeOut(100);
       }
    );


$('#logout').click(function(){           // при нажатии на ссылку будет отправлен запрос аякс обработает нажатие на кнопку выхода из профиля и если сессия завершена - выполнит перезагрузку страницы
    
    $.ajax({
  type: "POST",
  url: "/include/logout.php",
  dataType: "html",
  cache: false,
  success: function(data) {

  if (data == 'logout')
  {
      location.reload();
  }
  
}
}); 
});

$('#input-search').bind('textchange', function () {   // поисковик выподающий список
                 
 var input_search = $("#input-search").val();

if (input_search.length >= 3 && input_search.length < 150 )
{
 $.ajax({
  type: "POST",
  url: "/include/search.php",
  data: "text="+input_search,
  dataType: "html",
  cache: false,
  success: function(data) {

 if (data > '')
 {
     $("#result-search").show().html(data); 
 }else{
    
    $("#result-search").hide();
 }

      }
}); 

}else
{
  $("#result-search").hide();    
}

});



    //Шаблон проверки правильности ввода данных в форму заказа
    function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
    }
 // Контактные данные
  $('#confirm-button-next').click(function(e){   

   var order_fio = $("#order_fio").val();
   var order_email = $("#order_email").val();
   var order_phone = $("#order_phone").val();
   var order_address = $("#order_address").val();
   
 if (!$(".order_delivery").is(":checked"))
 {
    $(".label_delivery").css("color","#E07B7B");
    send_order_delivery = '0';

 }else { $(".label_delivery").css("color","black"); send_order_delivery = '1';

  
  // Проверка ФИО
 if (order_fio == "" || order_fio.length > 50 )
 {
    $("#order_fio").css("borderColor","#FDB6B6");
   send_order_fio = '0';
   
 }else { $("#order_fio").css("borderColor","#DBDBDB");  send_order_fio = '1';}

  
 //Проверка email
 if (isValidEmailAddress(order_email) == false)
 {
    $("#order_email").css("borderColor","#FDB6B6");
  send_order_email = '0';   
 }else { $("#order_email").css("borderColor","#DBDBDB"); send_order_email = '1';}
  
 // Проверка телефона
 
  if (order_phone == "" || order_phone.length > 50)
 {
    $("#order_phone").css("borderColor","#FDB6B6");
    send_order_phone = '0';   
 }else { $("#order_phone").css("borderColor","#DBDBDB"); send_order_phone = '1';}
 
 // Проверка адреса
 
  if (order_address == "" || order_address.length > 150)
 {
    $("#order_address").css("borderColor","#FDB6B6");
    send_order_address = '0';   
 }else { $("#order_address").css("borderColor","#DBDBDB"); send_order_address = '1';}
  
} 
 // Глобальная проверка
 if (send_order_delivery == "1" && send_order_fio == "1" && send_order_email == "1" && send_order_phone == "1" && send_order_address == "1")
 {
    // Отправляем форму
   return true;
 }

e.preventDefault();

});


// добавление товаров в корзину при нажатии кнопки карт
$('.add-cart-style-list,.add-cart-style-grid,.add-cart,.random-add-cart').click(function(){
              
 var  tid = $(this).attr("tid");

 $.ajax({
  type: "POST",
  url: "/include/addtocart.php",
  data: "id="+tid,
  dataType: "html",
  cache: false,
  success: function(data) { 
  loadcart();
      }
});

});

function loadcart(){
     $.ajax({
  type: "POST",
  url: "/include/loadcart.php",
  dataType: "html",
  cache: false,
  success: function(data) {
    
  if (data == "0")
  {
  
    $("#block-basket > a").html("Корзина пуста");
	
  }else
  {
    $("#block-basket > a").html(data);

  }  
    
      }
});    
       
}


 function fun_group_price(intprice) {  
    // Групировка цифр по разрядам добавляем пробелы в цены
  var result_total = String(intprice);
  var lenstr = result_total.length;
  
    switch(lenstr) {
  case 4: {
  groupprice = result_total.substring(0,1)+" "+result_total.substring(1,4);
    break;
  }
  case 5: {
  groupprice = result_total.substring(0,2)+" "+result_total.substring(2,5);
    break;
  }
  case 6: {
  groupprice = result_total.substring(0,3)+" "+result_total.substring(3,6); 
    break;
  }
  case 7: {
  groupprice = result_total.substring(0,1)+" "+result_total.substring(1,4)+" "+result_total.substring(4,7); 
    break;
  }
  default: {
  groupprice = result_total;  
  }
}  
    return groupprice;
    }



$('.count-minus').click(function(){   // функция для уменьшения колличества товара в корзине

  var iid = $(this).attr("iid");      
 
 $.ajax({
  type: "POST",
  url: "/include/count-minus.php",
  data: "id="+iid,
  dataType: "html",
  cache: false,
  success: function(data) {   
  $("#input-id"+iid).val(data);  
  loadcart();
  
  // переменная с ценой продукта в корзине
  var priceproduct = $("#tovar"+iid+" > p").attr("price"); 
  // Умножаем цену на колличество
  result_total = Number(priceproduct) * Number(data);
 
  $("#tovar"+iid+" > p").html(fun_group_price(result_total)+"руб.");
  $("#tovar"+iid+" > h5 > .span-count").html(data);
  
  itog_price();
      }
});
  
});

$('.count-plus').click(function(){  // функция для увеличения колличества товара в корзине

  var iid = $(this).attr("iid");      
  
 $.ajax({
  type: "POST",
  url: "/include/count-plus.php",
  data: "id="+iid,
  dataType: "html",
  cache: false,
  success: function(data) {   
  $("#input-id"+iid).val(data);  
  loadcart();
  
  // переменная с ценой продукта в корзине
  var priceproduct = $("#tovar"+iid+" > p").attr("price"); 
  // Умножаем цену на колличество
  result_total = Number(priceproduct) * Number(data);
 
  $("#tovar"+iid+" > p").html(fun_group_price(result_total)+"руб.");
  $("#tovar"+iid+" > h5 > .span-count").html(data);
  
  itog_price();
      }
});
  
});

 $('.count-input').keypress(function(e){ // определяет нажатие на кнопку ENTER и в случае нажатия будет считать колличество в поле инпут между +и- и выведет новые данные по цене
    
 if(e.keyCode==13){       // проверка нажатия именно на ENTER
	   
 var iid = $(this).attr("iid");
 var incount = $("#input-id"+iid).val();        
 
 $.ajax({
  type: "POST",
  url: "/include/count-input.php",
  data: "id="+iid+"&count="+incount,
  dataType: "html",
  cache: false,
  success: function(data) {
  $("#input-id"+iid).val(data);  
  loadcart();
    
  // переменная с ценой продукта в корзине
  var priceproduct = $("#tovar"+iid+" > p").attr("price"); 
  // Умножаем цену на колличество
  result_total = Number(priceproduct) * Number(data);


  $("#tovar"+iid+" > p").html(fun_group_price(result_total)+ "руб.");
  $("#tovar"+iid+" > h5 > .span-count").html(data);
  itog_price();

      }
}); 
  }
});

function  itog_price(){
 
 $.ajax({
  type: "POST",
  url: "/include/itog_price.php",
  dataType: "html",
  cache: false,
  success: function(data) {

  $(".itog-price > b").html(data);

}
}); 
       
}


$('#button-send-review').click(function(){
                
   var name = $("#name_review").val();
   var good = $("#good_review").val();
   var bad = $("#bad_review").val();
   var comment = $("#comment_review").val();
   var iid = $("#button-send-review").attr("iid");

    if (name != "")
     {
          name_review = '1';
          $("#name_review").css("borderColor","#DBDBDB");
      }else {
           name_review = '0';
           $("#name_review").css("borderColor","#FDB6B6");
      }
                  
    if (good != "")
       {
          good_review = '1';
          $("#good_review").css("borderColor","#DBDBDB");
      }else {
          good_review = '0';
          $("#good_review").css("borderColor","#FDB6B6");
      }
            
    if (bad != "")
     {
          bad_review = '1';
          $("#bad_review").css("borderColor","#DBDBDB");
     }else {
          bad_review = '0';
          $("#bad_review").css("borderColor","#FDB6B6");
     } 
                                         
            
            // коментарии и отзывы к товарам
            
    if ( name_review == '1' && good_review == '1' && bad_review == '1')
      {
         $("#button-send-review").hide();
         $("#reload-img").show();
                  
      $.ajax({
         type: "POST",
         url: "/include/add_review.php",
         data: "id="+iid+"&name="+name+"&good="+good+"&bad="+bad+"&comment="+comment,
         dataType: "html",
         cache: false,
         success: function() {
         setTimeout("$.fancybox.close()", 1000);
         }
         });  
         }         
});

$('#likegood').click(function(){
          
 var tid = $(this).attr("tid");
 
 $.ajax({
  type: "POST",
  url: "/include/like.php",
  data: "id="+tid,
  dataType: "html",
  cache: false,
  success: function(data) {  
  
  if (data == 'no')
  {
    alert('Вы уже проголосовали за этот продукт!');
  }  
   else
   {
    $("#likegoodcount").html(data);
   }

}
});
});

});