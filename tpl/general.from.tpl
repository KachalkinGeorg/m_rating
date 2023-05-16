<form method="post" action="">
	<div class="panel-body" style="font-family: Franklin Gothic Medium;text-transform: uppercase;color: #9f9f9f;">Настройки плагина</div>
	<div class="table-responsive">
	<table class="table table-striped">
      <tr>
        <td class="col-xs-6 col-sm-6 col-md-7">
		  <h6 class="media-heading text-semibold">Выберите каталог из которого плагин будет брать шаблоны для отображения</h6>
		  <span class="text-muted text-size-small hidden-xs"><b>Шаблон сайта</b> - плагин будет пытаться взять шаблоны из общего шаблона сайта; в случае недоступности - шаблоны будут взяты из собственного каталога плагина<br /><b>Плагин</b> - шаблоны будут браться из собственного каталога плагина</span>
		</td>
        <td class="col-xs-6 col-sm-6 col-md-5">
		  {{ localsource }}
        </td>
      </tr>
      <tr>
        <td class="col-xs-6 col-sm-6 col-md-7">
		  <h6 class="media-heading text-semibold">Возможность голосовать незарегестрированным пользователям:</h6>
		  <span class="text-muted text-size-small hidden-xs"><b>Да</b> - все вошедшие на сайт посетители смогут участвовать в голосовании.<br><b>Нет</b> - только зарегестрированные пользователи участвую в голосовании (для не зарегестрированных будет выводится сообщение)</span>
		</td>
        <td class="col-xs-6 col-sm-6 col-md-5">
			<select name="guest">{{ guest }}</select>
        </td>
      </tr>
      <tr>
        <td class="col-xs-6 col-sm-6 col-md-7">
		  <h6 class="media-heading text-semibold">Повторное голосование:</h6>
		  <span class="text-muted text-size-small hidden-xs"><b>Да</b> - давать возможность голосвать повторно.<br><b>Нет</b> - один голос, один посититель</span>
		</td>
        <td class="col-xs-6 col-sm-6 col-md-5">
			<select name="revote">{{ revote }}</select>
        </td>
      </tr>
	</table>
	</div>
	<div class="panel-footer" align="center">
		<button type="submit" name="submit" class="btn btn-outline-primary">Сохранить</button>
	</div>
</form>