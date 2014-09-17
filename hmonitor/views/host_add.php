<form name="<?=$this->form->name ?>" method="<?=$this->form->method ?>">
    <table>

        <tr>
            <td>
                http://
            </td>
            <td>
                <input type="text" name="host_name" value="">
            </td>
            <td>
                <input type="hidden" name="<?=$this->form->param_id ?>" value="<?=$this->form->id ?>">
                <input type="hidden" name="<?=$this->form->param_name ?>" value="<?=$this->form->name ?>">
                <input type="submit" value="add">
            </td>

            <td>
                <? if ($this->valid->result === true) {?>
                    <span style="color: green"><?=$this->valid->message ?></span>
                <? } else if ($this->valid->result === false) {?>
                    <span style="color: red"><?=$this->valid->message ?></span>
                <? } ?>
            </td>

        </tr>

    </table>
</form>
