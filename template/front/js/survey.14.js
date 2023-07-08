$( document ).ready(function() {

    $('#question0').toggle();

    $('#lightboxbutton').click(function(){
        $.featherlight('#lightbox', '');    
    });
    
    qnum = 1;
    sid = $( "body" ).data( "sid" );
    
    ga('send', 'pageview', sid + '/question' + qnum);
    
    $('.answer').click(function(){
        var a = $(this).parent();        
        //alert(a.attr('id'));
        a.toggle();
        nextquestion = '#' + a.attr('id') + '0';
        if ($(nextquestion).length) {
            $(nextquestion).toggle();
            qnum++;
            ga('send', 'pageview', sid + '/question' + qnum);
        }
        else { 
                survey_done();
                ga('send', 'pageview', sid + '/offers');
             }
    });
    
    track = $( "body" ).data( "track" );
    $("a").each(function()
       { 
          this.href = this.href.replace(/^http:\/\/track\.crtrack\.com/, 
             "http://" + track);
       });    
    
	clickhash = $( "body" ).data( "clickhash" );
	//history.replaceState(null, null, clickhash);
	
});

function convert_maybe()
{
    url = $( "body" ).data( "pixel" );
    $.ajax({
	  url: url,
	  context: document.body
	}).done(function() {
	  //alert(url);
	});	

}

function survey_done()
{
    
    owall = $( "body" ).data( "ow" );
    track = $( "body" ).data( "track" );
	transaction_id = $( "body" ).data( "transaction_id" );
	optkey = $( "body" ).data( "optkey" );
	sxid = $( "body" ).data( "sxid" );
    
	owallurl = "config/offerwall/" + owall + ".php?track=" + track + "&transaction_id=" + transaction_id + "&optkey=" + optkey + "&sxid=" + sxid;
	alert(owallurl);
    //$("#wallanchor").load(owallurl);

	$('#wallanchor').load(owallurl, function(response, status, xhr) {
    	if(status == 'error') {
      		$('#wallanchor').load(owallurl);
    	}
  	});	
	
    convert_maybe();
    //$('#reward').load("http://track.crtrack.com/click");
    
    $('#loading').fadeIn(100).delay(5000).fadeOut(0);
    $('#reward').delay(5100).fadeIn(0);
    $('#reward-text').delay(5100).fadeIn(0);
    $('#intro-text').delay(5100).fadeOut(0);
    
}