<{include file="public/header.tpl"}>
		<div id="main">
		  	<div class="head-dark-box">
				<div class="tit">后台管理->文章管理->修改文章</div>
			</div>	
			<{ include file="public/title.tpl" }>
		    <form name="article" method="post" action="<{$url}>/update">
			<div class="msg-box">
				<ul class="viewmess">
					<input type="hidden" name="id" value="<{$post.id}>">
					<li class="dark-row">
						<span class="col_width">文章类别</span>
						  <{ $select }>	
					</li>
					<li class="light-row">
						<span class="col_width">文章标题&nbsp;<span class="red_font">*</span></span>
						<input type="text" class="text-box" name="title" size="30" value="<{ $post.title }>" maxlength="40"> &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="button" onclick="window.location='<{$app}>/play/add/aid/<{$post.id}>'" value="设置幻灯播放">
					</li>

					<li class="dark-row">
						<span class="col_width" style="margin-top:25px">文章摘要</span>
						<textarea class="text-box" name="summary" cols="40" rows="4"><{ $post.summary }></textarea>&nbsp;&nbsp;小于100个汉字.
					</li>

					<li class="light-row">
						<span class="col_width">文章来源</span>
						<input type="text" class="text-box" name="comefrom" size="25" value="<{ $post.comefrom }>" maxlength="25">
					</li>
					<li class="dark-row">
						<span class="col_width">关键字&nbsp;&nbsp;&nbsp;<span class="red_font">*</span></span>
						<input type="text" class="text-box" name="keyword" size="25" value="<{ $post.keyword }>" maxlength="20">&nbsp;&nbsp;用于文章搜索,多个请用逗号","隔开.
					</li>
					<li class="light-row">
						<span class="col_width">是否推荐</span>
						<input type="radio"  name="recommend"<{if $post.recommend eq 1}>checked<{/if}>  value="1"> 推荐
						<input type="radio"  name="recommend" <{if $post.recommend eq 0}>checked<{/if}> value="0"> 不推荐
					</li>
					<li class="dark-row">
						<span class="col_width">是否充许评论</span>
						<input type="radio"  name="allow"<{if $post.allow eq 1}>checked<{/if}>  value="1"> 充许
						<input type="radio"  name="allow" <{if $post.allow eq 0}>checked<{/if}> value="0"> 不充许
					</li>
				
					<li class="light-row" style="margin:0px; padding:0px">
						<textarea cols="80" rows="10" name="content"><{$post.content}></textarea>
						<{$ck}>
					</li>
				
	
					<li class="dark-row">
						<span class="col_width">&nbsp;  </span>
						<input type="submit" class="button"  value="修 改">&nbsp;&nbsp;
						<input type="reset" class="button" value="重 置">&nbsp;&nbsp;
						<input type="button" onclick="if(confirm('确定要删除吗?')) window.location='<{$url}>/del/id/<{$post.id}>'" class="button" value="删 除">
					</li>
				</ul>	
			</div>
                    </form>	
		</div>
<{include file="public/footer.tpl"}>	


