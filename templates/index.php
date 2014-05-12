<style>
<!--
.QueryHelper{border: 1px solid #4f4f4f; margin: 10px auto; max-width: 1024px;}
.QueryHelper .title{cursor: pointer; background-color: #4496ce; padding: 4px; color: #e0f2f9; 
    font-weight: bold; padding-bottom: 4px;}
.QueryHelper .title.level-warning{color: #cecd69;}
.QueryHelper .title.level-critical{color: #ce2127;}
.QueryHelper .title:hover{background-color: #2A5685; color: #b8c7ce;}
.QueryHelper .title.level-warning:hover{color: #cecd69;}
.QueryHelper .title.level-critical:hover{color: #ce2127;}
.QueryHelper .body{max-width:1000px; overflow-x: scroll; margin: 10px 3px;}
.QueryHelper .item{border-bottom: 1px solid #263a4f;}
.QueryHelper .body{display: block; height: auto;}
.QueryHelper .query .preview{padding-left: 20px;}
.QueryHelper .query .execTime{width: 70px; display: inline-block;}
.QueryHelper .extra{display: block;height: auto; margin: 5px 10px;}
.QueryHelper .flag{display: inline-block; height: 14px !important; width: 14px; min-width:14px; 
    min-height:14px; text-align: center; margin-right: 5px; border: 1px solid #e0f2f9;
}
.QueryHelper .flag:before{content: "-";}
.QueryHelper .collapsed .flag:before{content:"+";}
.QueryHelper .collapsed .body{display: none;height: 0px;}
.QueryHelper .collapsed .extra{display: none;height: 0px;}
.QueryHelper .collapsed .flag{display: inline-block;height: 0px;}
.QueryHelper .totalTime{font-size: 120%; font-weight: bold; margin: 15px 5px 5px 5px;}
-->
</style>
<div id="QueryHelper" class="QueryHelper">
    <?php foreach($data as $itemNo => $item) {?>
    <div class="item " data-execTime="<?php echo (float)$item["time"]; ?>" data-callOrder="<?php echo $item["order"];?>">
        <div class="query collapsed">
            <div class="title level-<?php echo $item["level"]; ?>">
                <span class="flag"></span>
                <span class="execTime"><?php echo round($item["time"], 6);?></span>
                <span class="preview">&laquo;<?php echo substr(trim(htmlspecialchars($item["query"])), 0, 60); ?> ...&raquo;</span>
            </div>
            <div class="body">
                <pre><?php echo htmlspecialchars($item["query"]); ?></pre>
            </div>
            <div class="extra">
                <div class="explain collapsed">
                    <div class="title">
                        <span class="flag"></span>
                        <span class="label">Explain</span>
                    </div>
                    <div class="body">
                        <pre><?php echo $item["explain"];?></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php }//foreach ?>
    <div class="totalTime">Total time: <?php echo $totalTime;?></div>
</div>
<script>window.jQuery || document.write('<script src="http://code.jquery.com/jquery-1.11.1.min.js"><\/script>')</script>
<script type="text/javascript">
// <![CDATA[
    $(document).ready(function(){
        $('#QueryHelper .item .title').click(function(){
            $(this).parent().toggleClass('collapsed');
        });
    });
// ]]>
</script>
