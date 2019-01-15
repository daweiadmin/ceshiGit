$(function() {
    $('#ClickMe').click(function() {
        $('#code').center();
        $('#goodcover').show();
        $('#code').fadeIn();
    });
    $('#closebt').click(function() {
        $('#code').hide();
        $('#goodcover').hide();
    });
	$('#goodcover').click(function() {
        $('#code').hide();
        $('#goodcover').hide();
    });
    
    

})
$(function() {
    $('#ClickMe2').click(function() {
        $('#code2').center();
        $('#goodcover2').show();
        $('#code2').fadeIn();
    });
    $('#closebt2').click(function() {
        $('#code2').hide();
        $('#goodcover2').hide();
    });
	$('#goodcover2').click(function() {
        $('#code2').hide();
        $('#goodcover2').hide();
    });
    
    

})

$(function() {
    //alert($(window).height());
    $('#ClickMe1').click(function() {
        $('#code1').center();
        $('#goodcover1').show();
        $('#code1').fadeIn();
    });
    $('#closebt1').click(function() {
        $('#code1').hide();
        $('#goodcover1').hide();
    });
	$('#goodcover1').click(function() {
        $('#code1').hide();
        $('#goodcover1').hide();
    });
    /*var val=$(window).height();
	var codeheight=$("#code").height();
    var topheight=(val-codeheight)/2;
	$('#code').css('top',topheight);*/
    jQuery.fn.center = function(loaded) {
        var obj = this;
        body_width = parseInt($(window).width());
        body_height = parseInt($(window).height());
        block_width = parseInt(obj.width());
        block_height = parseInt(obj.height());

        left_position = parseInt((body_width / 2) - (block_width / 2) + $(window).scrollLeft());
        if (body_width < block_width) {
            left_position = 0 + $(window).scrollLeft();
        };

        top_position = parseInt((body_height / 2) - (block_height / 2) + $(window).scrollTop());
        if (body_height < block_height) {
            top_position = 0 + $(window).scrollTop();
        };

        if (!loaded) {

            obj.css({
                'position': 'fixed'
            });
            obj.css({
                'bottom': 0,
                'left': 0
            });
            $(window).bind('resize', function() {
                obj.center(!loaded);
            });

        } else {
            obj.stop();
            obj.css({
                'position': 'fixed'
            });
        }
    }

})