<script>
    <?//анимация увеличение?>
    $('.breif-item').hover(function () {
        let element = $(this);
        let color = element.css('background-color');
        let hovered = "0px 0px 20px" + " " + color;
        element.css({"transform":"scale(1.03)", "box-shadow": hovered , "transition": ".4s"});
    }, function() {
        $(this).css({"transform":"scale(1)", "box-shadow": "none", "transition": ".4s"});
    });
</script>