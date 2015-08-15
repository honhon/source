<script language="javascript">
	$(document).ready(function(){
		$('#btnSearch').click(function(){ search(); });
	});
	
	function search(){
		$('#msg').html('変換中.....');
		var Operation     = $("#Operation").val();
		var SearchIndex   = $("#SearchIndex").val();
		var ResponseGroup = $("#ResponseGroup").val();
		var Sort          = $("#Sort").val();
		var Title         = $("#Title").val();
		var Author        = $("#Author").val();
		var Keywords      = $("#Keywords").val();
		$.ajax({url:      '/p/toybox/amazon/'
			  , type:     'post'
			  , data:     {'act':'search','Operation':Operation,'SearchIndex':SearchIndex,'ResponseGroup':ResponseGroup,'Sort':Sort,'Title':Title,'Author':Author,'Keywords':Keywords}
			  , timeout:  10000
			  , async:    true
			  , error:    function()   { $('#msg').html('通信エラー'); }
			  , success:  function(res){
							  $('#msg').html('<iframe src="' + res + '" width="800px" height="800px"></iframe>'); 
						  }
		});
	}
</script>
<style type="text/css">
	div#msg {font-weight:bold;}
</style>
<h1 id="subtitle"><span class="subtitle">■</span> アマゾン</h1>
<br clear="all" />
<table>
<tr><td>Operation</td>    <td><input type="text" size="30" id="Operation"     value="ItemSearch" /></td><td>ItemSearch,ItemLookup,SimilarityLookup,SellerListingSearch,SellerListingLookup</td></tr>
<tr><td>SearchIndex</td>  <td><input type="text" size="30" id="SearchIndex"   value="Books" /></td>     <td>Blended, Books, ForeignBooks, Electronics, Kitechen, Music, DVD, Video, Software, VideoGames, toys</td></tr>
<tr><td>ResponseGroup</td><td><input type="text" size="30" id="ResponseGroup" value="Large" /></td>     <td>Request, Itemlds, Small, Medium, Large, OfferSummary, Offers, OfferFull, ItemAttributes, Tracks, Accessories, EditorialReview, SalesRank, BrowseNodes, Images, Similarities, Reviews, ListmaniaLists</td></tr>
<tr><td>Sort</td>         <td><input type="text" size="30" id="Sort"          value="daterank" /></td>  <td>salesrank, pricerank, inverse-princerank, daterank, titlerank, -titlerank</td></tr>
<tr><td>Title</td>        <td><input type="text" size="30" id="Title"         value="" /></td>          <td>Keywords, Title, Power, BrowseNode, Artist, Author, Actor, Director, AudienceRating, Manufacturer, MusicLabel, Composer, Publisher, Brand, Conductor, Orchestra, TextStream, Cuisine, City, Neighborhood</td></tr>
<tr><td>Author</td>       <td><input type="text" size="30" id="Author"        value="" /></td>          <td></td></tr>
<tr><td>Keywords</td>     <td><input type="text" size="30" id="Keywords"      value="" /></td>          <td></td></tr>
<tr><td colspan="3"><button id="btnSearch">search</button></td></tr>
</table>
<input type="hidden" name="AssociateTag" value="honplalajp-22" />
<div id="msg"></div>