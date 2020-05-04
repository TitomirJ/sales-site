(function($, undefined){
    $(function(){



        let arr_words = [];
        /**
         * создание массива слов для поиска
         * полученных из поля инпута от пользователя и
         * отображения их на странице
         */
        $('#btn_add_keyword').on('click',function(e){
            //let item_id = $('#id_item_add_word').val();
            
            
            if(getKeywords()){
               let keyword = getKeywords();
            arr_words.push(keyword);
            
            //TO DO сделать запись в БД массива arr_words аяксом
            //и на странице выводить записанные слова с возможностью их удаления
            //(скорее всего массив формировать в контроллере перед записью)

            $.ajax({
                type: 'POST',
					url: '/company/product/add_keywords',
                    data:$('#form_add_words').serialize(),

					success:function(result){
                        
                        rendervalidResponseAjax(result);
                        
					}
            })
         
            }else{
                alert('Использованы недопустимые символы !!');
                $('#input_add_words').val('');
            }
            
        })

        /**
         * отмена отправки формы по нажатию enter для поля ввода слов
         */
        $("#input_add_words").keydown(function(event){
            if(event.keyCode == 13){
                event.preventDefault();
                return false;
                }
        });


        /**
         * получение слово из инпута введенного пользователем
         */
        function getKeywords(){
            let word = $.trim($("#input_add_words").val());
          
            if(is_valid(word)){
                return word;
             }else{
                 return false;
             }
            return true;
        }

        /**
         * валидация данных от пользователя из поля добавления слов для поиска
         * @param {string} word 
         */
        function is_valid(word){
            let patern = /[а-яА-Яa-zA-Z]/g;
            let tag = /\<(\/?[^\>]+)\>/;
            if(patern.test(word) && !tag.test(word)){
                return true;
            }else{
                return false;
            }
        }


        function render_words(result){
            
            $('#words_add_user').text('');
            $.each(result, function (index, value) {
            
              $('#words_add_user').append('<span class="key_word_from_user btn btn-success m-2">'+value+'</span>');  
           
              })
   
        }


        /**
         * для удаления слова событие на клик
         * передача текста в контроллер чтобы удалить его в БД
         */
        $('#words_add_user').on('click','.btn', function(e){
            let delword = $(this).text();
           
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                type: 'POST',
                    url: '/company/product/del_keywords',                  
                    data:{word:delword},

					success:function(result){
                        
                        rendervalidResponseAjax(result);
                        
                        
					}
            })
            })


       function rendervalidResponseAjax(result){
        if(result == 'notformat'){
            alert('Не правильно введенные символы');
            $('#input_add_words').val('');
            
        }else{
           console.log(result);
        $("#input_add_words").val('');
            render_words(result); 
        }
       }


       /**
        * визуализация заставки при нажатии на кнопки привязки и очистки 
        */
       $('#add_subcat_words').on('click',function(e){
            $('#overlay-loader').show();
       })
      
       $('#del_subcat_words').on('click',function(e){
        $('#overlay-loader').show();
   })




    });
})(jQuery);