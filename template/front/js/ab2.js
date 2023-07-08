
reward_set = false;
click_count = 0;

if(typeof jQuery=='undefined') {
	var headTag = document.getElementsByTagName("head")[0];
	var jqTag = document.createElement('script');
	jqTag.type = 'text/javascript';
	jqTag.src = '//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js';
	jqTag.onload = trapClick;
	headTag.appendChild(jqTag);
} else {
	/* trapClick(); */
}	

/*
function trapClick() {
		
	$(document).mousedown(function(){

		if (click_count > 2 && !reward_set)
		{
			ab_reward();
			reward_set = true;
		}
        else
        {
            click_count ++;
        }
	});
	
}	
*/

function ab_reward() 
{
    if (!reward_set)
    {
        reward_set = true;

		pool = $( "body" ).data( "pool" );
		
        ids = '';
        $('span.ab_reward').each(function() { 
            ids += $(this).attr('class').split(' ')[0] + ',';
        });
        url = location.protocol + '//' + location.host + location.pathname + '?reward=' + ids + "&pool=" + pool;	

        $.ajax({
          url: url,
          context: document.body
        }).done(function() {
          //alert(url);
        });	
    }	
}