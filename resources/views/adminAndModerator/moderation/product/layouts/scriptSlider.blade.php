<script>
    //slider mouse move
    var isMouseDown = false;
    var click = false;
    var startPosMouse = 0;

    function isLeftButton(event){
        var button = event.which ? event.which : event.button;
        return button < 2;
    }

    $('#cases').mousedown(function(event){
        if (isLeftButton(event)){
            isMouseDown = true;
            click = true;
            startPosMouse = event.clientX;
        }
    });

    $('#cases').mouseup(function(){
        if (isLeftButton(event)){
            isMouseDown = false;
            startPosMouse = 0;
        }
    });
    $('#cases').mousemove(function(event){
        if (isMouseDown){
            if(startPosMouse < (event.clientX-200) && click){
                $('.carousel-control-prev').click();
                click = false;
            }else if(startPosMouse > (event.clientX+200) && click){
                $('.carousel-control-next').click();
                click = false;
            }
        }
    });

    $('#cases').on('touchstart', function (event, a) {

        var touch = event.originalEvent.changedTouches[0];
        endSwipeX = touch.pageX;

        isMouseDown = true;
        click = true;

        startPosMouse = endSwipeX;
    });

    $('#cases').on('touchmove', function(event){
        var touch = event.originalEvent.changedTouches[0];

        if (isMouseDown){
            if(startPosMouse < (touch.pageX-100) && click){
                $('.carousel-control-prev').click();
                click = false;
            }else if(startPosMouse > (touch.pageX+100) && click){
                $('.carousel-control-next').click();
                click = false;
            }
        }
    });

    //end slider mouse move
</script>