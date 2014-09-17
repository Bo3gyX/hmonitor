<table border="1">

    <tr>
        <td colspan="3">Результат поиска</td>
    </tr>

    <? foreach($this->list as $host) { ?>
    <tr>
        <?
        /**
         * @var $host \hmonitor\classes\Host
         */
        ?>
        <td><?=$host->getDateCreate()?></td>
        <td><?=$host->url?></td>
        <td><?=$host->desc?></td>
    </tr>
    <? } ?>
</table>