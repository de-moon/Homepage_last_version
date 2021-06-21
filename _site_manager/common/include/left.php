<div id="gnb">
	<ul>
		<?php if ($_SESSION['MALGUM_AUTHORITY'] == "SUPER" || $_SESSION['MALGUM_AUTHORITY'] == "PART" || (2 & $_SESSION['MALGUM_AUTHORITY_DETAIL']) > 0) { ?>
		<li>
			<a href="#">게시물 관리</a>
			<ul>
				<li class="<?php If ($MENU_DEPTH_1 == "NEWS" && $MENU_DEPTH_2 == "NEWS_PRESS") { echo "selected"; } ?>"><a href="<?=$ADMINROOT?>/news/news_press/board_list.php">보도자료</a></li>
				<li class="<?php If ($MENU_DEPTH_1 == "SETTING" && $MENU_DEPTH_2 == "POPUP") { echo "selected"; } ?>"><a href="<?=$ADMINROOT?>/site/popup/board_list.php">POPUP</a></li>
			</ul>
		</li>
		<li>
			<a href="#">상담 관리</a>
			<ul>
				<li class="<?php If ($MENU_DEPTH_1 == "BOARD" && $MENU_DEPTH_2 == "CONTACT") { echo "selected"; } ?>"><a href="<?=$ADMINROOT?>/board/contact/board_list.php">고객문의</a></li>
			</ul>
		</li>
		<li>
			<a href="#">시스템 관리</a>
			<ul>
				<li class="<?php If ($MENU_DEPTH_1 == "MEMBER" && $MENU_DEPTH_2 == "ADMIN") { echo "selected"; } ?>"><a href="<?=$ADMINROOT?>/member/admin/board_list.php">관리자</a></li>
			</ul>
		</li>
		<?php } ?>
	</ul>
</div>