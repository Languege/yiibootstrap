
  <div class="col-md-2 column" style="height:100%;">
    <ul class="list-unstyled">
    <?php foreach ($menus as $key => $menu) {?>
      <li class="pMenu">
        <a href="index.php?r=<?=$menu['child_actions'][0]['url']?>" target="iframedo" class="list-group-item"><?=$menu['name'];?></a>
        <ul class="list-unstyled">
          <?php foreach ($menu['child_actions'] as $submenu) {?>
          <li class="cMenu"><a href="index.php?r=<?=$submenu['url']?>" target="iframedo"><?=$submenu['name']?></a></li>
          <?php }?>
        </ul> 
      </li>
    <?php }?>
    </ul>
  </div>
  <div class="col-md-10 column" style="height:100%;">
    <iframe src="" style="border:0px;width:100%;height:100%" id="iframedo" name="iframedo"></iframe>
  </div>
<script type="text/javascript">
$(function(){
$(".cMenu").click(function(){
  $(".cMenu").removeClass("active");
  $(".pMenu").removeClass("active");
  $(this).addClass("active");
  $(this).closest('.submenu').addClass("active");
});

$(".pMenu a").click("click",function(){
    var close = $(this).next("ul").is(":hidden");
    if(close){
        $(this).next("ul").show();
    }else{
        $(this).next("ul").hide();
    }
});

$(".pMenu:eq(0)").addClass("active").find("ul").show();
$(".pMenu:eq(0)").find(".cMenu:eq(0)").addClass("active");
var href = ($(".pMenu:eq(0)").find(".cMenu:eq(0) a").attr("href"));
$("#iframedo").attr("src",href);
});

</script>
</body>
</html>
