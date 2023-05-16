<script>
var alert_timeout = null;

function showAlert(msg){
	clearInterval(alert_timeout);
	$(".m-error").remove();
	$('.m-rating-area').append('<div class="m-error"/>');
	$(".m-error").html(msg).fadeIn(200);
	alert_timeout = setTimeout(function(){$(".m-error").fadeOut(500,function(){$(this).remove()})},2000);
	return false;
}

$(document).ready(function(){
  $(".m-rating li").mouseenter(function(){
	var m_index = $(this).index()+1;
	$(this).parent().find('li').each(function(i){
		if(m_index>i) $(this).addClass('m-hover');
	});
  });
  $(".m-rating li").mouseleave(function(){
	$(this).parent().find('li').removeClass('m-hover');
  });
  $(".m-rating li").click(function(){
	$(".m-rating-rate").addClass('m-load');
	var m_index = $(this).index()+1;
	var $this = $(this).parent();
	ngShowLoading();
	$.post('/engine/rpc.php', { json : 1, methodName : 'plugin.m_rating.get', rndval: new Date().getTime(), params : json_encode({news_id:$('.m-rating-area').data('id'),area:$this.data('area'),go_rate:m_index}) },function(d){
		ngHideLoading();
		$(".m-rating-rate").removeClass('m-load');
		if(d.error) showAlert(d.error);
		$('.m-rating-area').html(d.html);
		showAlert(d.error);
	});
  });
});

</script>

<div class="m-rating-rate">
	{{rate}}
	<div class="m-rating-rate-votes">{{votes}} голосов</div>
</div>

<div class="m-rating-column">
	<div class="m-rating-field">
		<div class="m-rating-value" title="{{tvideo}} голосов">{{rvideo}}</div>
		Графика:
		<ul class="m-rating" data-area="video">{{video}}</ul>
	</div>

	<div class="m-rating-field">
		<div class="m-rating-value" title="{{tgameplay}} голосов">{{rgameplay}}</div>
		Геймплей:
		<ul class="m-rating" data-area="gameplay">{{gameplay}}</ul>
	</div>
</div>

<div class="m-rating-column">
	<div class="m-rating-field">
		<div class="m-rating-value" title="{{tsound}} голосов">{{rsound}}</div>
		Озвучка:
		<ul class="m-rating" data-area="sound">{{sound}}</ul>
	</div>

	<div class="m-rating-field">
		<div class="m-rating-value" title="{{tatm}} голосов">{{ratm}}</div>
		Атмосфера:
		<ul class="m-rating" data-area="atm">{{atm}}</ul>
	</div>
</div>

<div class="m-rating-itog">
	<center>Оценка: <b class="m-rating-itog-rateval">{{rate}}</b> из 10 <i>(голосов: <span class="m-rating-itog-votes">{{votes}}</span>)</i></center>
</div>