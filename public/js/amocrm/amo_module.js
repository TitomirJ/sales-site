
    var CustomWidget = function () {
        var self = this;
        var system = self.system();





        $('*').on('click', function (e) {
            e.preventDefault();
            console.log(e.currentTarget);
            // var elems = $(this);
            // elems.each(function (index, elem) {
            //     console.log(index);
            // });
        });
        // this.get_ccard_info = function ()
        // {
        //     if (self.system().area == 'ccard') {
        //
        //         var phones = $('.card-cf-table-main-entity .phone_wrapper input[type=text]:visible'),
        //             emails = $('.card-cf-table-main-entity .email_wrapper input[type=text]:visible'),
        //             name = $('.card-top-name input').val(),
        //             data = [],
        //             c_phones = [], c_emails = [];
        //         data.name = name;
        //         for (var i = 0; i < phones.length; i++) {
        //             if ($(phones[i]).val().length > 0) {
        //                 c_phones[i] = $(phones[i]).val();
        //             }
        //         }
        //         data['phones'] = c_phones;
        //         for (var i = 0; i < emails.length; i++) {
        //             if ($(emails[i]).val().length > 0) {
        //                 c_emails[i] = $(emails[i]).val();
        //             }
        //         }
        //         data['emails'] = c_emails;
        //
        //         return data;
        //     }
        //     else {
        //         return false;
        //     }
        // };
        //
        // var params = [
        //     {name:'name1',
        //         id: 'id1'},
        //     {name:'name2',
        //         id: 'id2'},
        //     {name:'name3',
        //         id: 'id3'}
        // ];
        //
        // var template = '<div><ul>'+
        //     '{% for person in names %}'+
        //     '<li>Name : {{ person.name }}, id: {{ person.id }}</li>'+
        //     '{% endfor %}'+
        //     '</ul></div>';
        //
        // console.log(self.render({data : template},
        //     {names: params}));
        // //console.log($('.list-row').remove());

        this.ajax = function (url, data=null, callback) {
            self.crm_post(
                url,
                {data},
                function (msg) {
                    callback(msg);
                },
                'json'
            );
        };

        this.callbacks = {
            render: function(){

                console.log(system);
                return true;
            },
            init: function(){

                return true;
            },
            bind_actions: function(){



                if (self.system().area == 'lcard') {
                    var userLogin = system.amouser;
                    var userHash = system.amohash;
                    var domain = system.subdomain;
                    var dataAuth = {
                        login : userLogin,
                        key : '249207348ce648896f8a0c9a99919693bf42eb1f',
                        subdomen : domain,
                    };

                    self.ajax(url = 'https://bigsales.pro/js/amocrm/test.php?test=test', dataAuth, data => {
                        console.log(data)
                    });
                }

                $(".todo-line__item-lead").click(function(e) {
                    e.preventDefault();
                    console.log($(this));

                });
                console.log(self.get_settings());
                return true;
            },
            settings: function(){
                return true;
            },
            onSave: function(){
                alert('click');
                return true;
            },
            destroy: function(){

            },
            contacts: {

                selected: function(){
                    alert('contacts');
                }
            },
            leads: {

                selected: function(){
                    console.log('leads');
                }
            },
            tasks: {

                selected: function(){
                    console.log('tasks');
                }
            }
        };
        return this;
    };

