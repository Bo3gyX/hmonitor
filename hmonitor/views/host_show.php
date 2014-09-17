<table border="1">

    <tr>
        <td colspan="3">TOP 10 Недавно добавленные</td>
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