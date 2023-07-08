function claim_offer(offer_url,offer_alert,target_window)
{
    ab_reward();
    
    click = 'click - ' + offer_url; 
    ga('send', 'event', 'Outbound Links', 'Click', click);

	if (offer_alert) {alert(offer_alert);}

	if (target_window) {window.open(offer_url,target_window);} else {window.open(offer_url);}
}

function reward_only(offer_url)
{
    ab_reward();
    
    click = 'click - ' + offer_url; 
    ga('send', 'event', 'Outbound Links', 'Click', click);

}