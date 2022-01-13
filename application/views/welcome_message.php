<style>
	.vitalStickyNote
	{
		margin: 5px auto;
		font-family: "Lato";
		background:#fafafa;
		color:#fff;
		margin:0!important;
		padding:0!important;

	}
	.h2_sticky
	{
		font-weight: bold;
		font-size:12px!important;
	}
	.sticky_value
	{

		font-size:20px!important;
		text-align:center;
		font-weight:bold;
	}
	.sticky_ul,.sticky_li
	{
		list-style:none!important;
		text-decoration:none!important;
	}
	.sticky_ul
	{
		display: flex!important;
		flex-wrap: wrap!important;
	// justify-content: center!important;

	}
	.sticky_a
	{
		text-decoration:none!important;
		color:#000;
		background:#fccc;
		display:block;
		height:5em;
		width:5em;
		padding:.5em;
		box-shadow: 5px 5px 7px rgba(33,33,33,.7);
		transition: transform .15s linear;
	}
	.sticky_li
	{
		margin:1em;
	}
</style>
<div class="row">
	<div class="vitalStickyNote">
		<ul class="sticky_ul">
			<li class="sticky_li">
				<a class="sticky_a" style="background:#ff7455">
					<h2 class="h2_sticky">HR Bpm</h2>
					<p class="sticky_value">124</p>
				</a>
			</li>
			<li class="sticky_li">
				<a class="sticky_a" style="background:#1ba8b1">
					<h2 class="h2_sticky">SpO2 %</h2>
					<p class="sticky_value">98</p>
				</a>
			</li>
			<li class="sticky_li">
				<a class="sticky_a" style="background:#ff0079">
					<h2 class="h2_sticky">RR rpm</h2>
					<p class="sticky_value">24</p>
				</a>
			</li>
		</ul>
		<ul class="sticky_ul">
			<li class="sticky_li">
				<a class="sticky_a" style="background:#ff7455">
					<h2 class="h2_sticky">HR Bpm</h2>
					<p class="sticky_value">124</p>
				</a>
			</li>
			<li class="sticky_li">
				<a class="sticky_a" style="background:#1ba8b1">
					<h2 class="h2_sticky">SpO2 %</h2>
					<p class="sticky_value">98</p>
				</a>
			</li>
			<li class="sticky_li">
				<a class="sticky_a" style="background:#ff0079">
					<h2 class="h2_sticky">RR rpm</h2>
					<p class="sticky_value">24</p>
				</a>
			</li>
		</ul>
	</div>

</div>
</div>
<div class="row justify-content-center">
<!--	<small class="py-1 font-italic">' . $date . '</small>-->
</div>
