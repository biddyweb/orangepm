<style type="text/css">
    td.edit{
        cursor:pointer;
    }

    a img{
        border: NONE;
    }

</style>
<form action="<?php echo url_for('project/addStory?id=' . $projectId); ?>" method="GET">
    <input type="submit" value="ADD" />
</form>

<?php echo "REGISTRED STORIES"; ?>

<br/>

<table border ="1">
    <tr>
        <th>Story Id</th>
        <th>Story Name</th>
        <th>Effort estimation</th>
        <th>Date Added</th>
    </tr>

    <?php foreach ($storyList as $story): ?>
        <tr id="row">
            <td class="<?php echo "not id " . $story->getId(); ?>"><?php echo $story->getId(); ?></td>
            <td class="<?php echo "changedName name " . $story->getId(); ?>"><?php echo $story->getName(); ?></td>
            <td class="<?php echo "changedEstimation estimation " . $story->getId(); ?>"> <?php echo $story->getEstimation(); ?></td>
            <td class="<?php echo "changedDate date " . $story->getId(); ?>"> <?php echo $story->getDateAdded(); ?></td>
            <td class="<?php echo "edit edit " . $story->getId(); ?>"><?php echo image_tag('b_edit.png') ?></td>
            <td>  <a href="<?php echo url_for("project/deleteStory?id={$story->getId()}&projectId={$projectId}"); ?> " > <?php echo image_tag('b_drop.png'); ?></a></td>

        </tr>
    <?php endforeach; ?>
    </table>

    <script type="text/javascript">
        $(document).ready(function(){

            $('td.edit').click(function(){

                $(this).parent().children('td.changedName').addClass('ajaxName');
                $(this).parent().children('td.changedName').html('<input id="editboxName" size="'+$(this).parent().children('td.changedName').text().length+'" type="text" value="' + $(this).parent().children('td.changedName').text() + '">');
                $(this).parent().children('td.changedDate').addClass('ajaxDate');
                $(this).parent().children('td.changedDate').html('<input id="editboxDate" size="'+$(this).parent().children('td.changedDate').text().length+'" type="text" value="' + $(this).parent().children('td.changedDate').text() + '">');
                $(this).parent().children('td.changedEstimation').addClass('ajaxEstimation');
                $(this).parent().children('td.changedEstimation').html('<input id="editboxEstimation" size="'+$(this).parent().children('td.changedEstimation').text().length+'" type="text" value="' + $(this).parent().children('td.changedEstimation').text() + '">');
                
            });
            
         
            $('td.changedName, td.changedDate, td.changedEstimation').keydown(function(event){
                arr = $(this).attr('class').split( " " );

                if(event.which == 13)
                {
                    $.ajax({    type: "POST",
                        url: "<?php echo url_for('project/editStory') ?>",
                        data: "name="+$('.ajaxName input').val()+"&date="+$('.ajaxDate input').val()+"&estimation="+$('.ajaxEstimation input').val()+"&id="+arr[2],
                        success: function(){
                            $('.ajaxName').html($('.ajaxName input').val());
                            $('.ajaxDate').html($('.ajaxDate input').val());
                            $('.ajaxEstimation').html($('.ajaxEstimation input').val());
                            $('.ajaxName').removeClass('ajaxName');
                            $('.ajaxDate').removeClass('ajaxDate');
                            $('.ajaxEstimation').removeClass('ajaxEstimation');
                        
                    }});
                
            }
        }

    );
    });


</script>

