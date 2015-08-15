<style type="text/css">
	table.doc {width:98%;}
	table.doc th {background-color:#aabbcc;}
	table.doc td {background-color:#ddeeff;}
	.docTitle {text-align:left;font-weight:bold;font-size:18px;}
	.docContents {text-align:left;padding-left:12px;}
</style>
<div id="frame2Right">
	<a name="top"></a>
<!-- GMap //-->
	<a name="GMap"><div class="docTitle">GMap</div></a>
	<table class="doc">
		<col width="120px" />
		<col />
		<tr>
			<th>コンストラクタ</th>
		</tr>
		<tr>
			<td><b>GMap</b>(container, mapTypes?, width?, height?)</td>
		</tr>
	</table>
	<table class="doc">
		<col width="120px" />
		<col />
		<tr>
			<th colspan="2">メソッド</th>
		</tr>
		<tr><td>void</td><td><b>enableDragging</b>()<br />&nbsp;&nbsp;&nbsp;
					マップのドラッグを可能にする(デフォルト)</td></tr>
		<tr><td>void</td><td><b>disableDragging</b>()<br />&nbsp;&nbsp;&nbsp;
					マップのドラッグを不能にする</td></tr>
		<tr><td>boolean</td><td><b>draggingEnabled</b>()<br />&nbsp;&nbsp;&nbsp;
					マップがドラッグ可能か否か</td></tr>
		<tr><td>void</td><td><b>enableInfoWindow</b>()<br />&nbsp;&nbsp;&nbsp;
					マップ上にポップアップウィンドウの表示を可能にする(デフォルト)</td></tr>
		<tr><td>void</td><td><b>disableInfoWindow</b>()<br />&nbsp;&nbsp;&nbsp;
					マップ上にポップアップウィンドウの表示を不能にする</td></tr>
		<tr><td>boolean</td><td><b>infoWindowEnabled</b>()<br />&nbsp;&nbsp;&nbsp;
					マップ上にポップアップウィンドウの表示が可能か否か</td></tr>
		<tr><td>void</td><td><b>addControl</b>(control)<br />&nbsp;&nbsp;&nbsp;
				 	マップコントロールを追加する</td></tr>
		<tr><td>void</td><td><b>removeControl</b>(control)<br />&nbsp;&nbsp;&nbsp;
					マップコントロールを除去する</td></tr>
		<tr><td><a href="#GPoint">GPoint</a></td><td><b>getCenterLatLng</b>()<br />&nbsp;&nbsp;&nbsp;
				 	マップ中央の緯度･経度の座標点</td></tr>
		<tr><td><a href="#GBounds">GBounds</a></td><td><b>getBoundsLatLng</b>()<br />&nbsp;&nbsp;&nbsp;
					マップの表示域(右上と左下の座標情報)</td></tr>
		<tr><td><a href="#GSize">GSize</a></td><td><b>getSpanLatLng</b>()<br />&nbsp;&nbsp;&nbsp;
					マップの表示域の緯度の差と経度の差</td></tr>
		<tr><td>int</td><td><b>getZoomLevel</b>()<br />&nbsp;&nbsp;&nbsp;
					マップのズームレベル</td></tr>
		<tr><td>void</td><td><b>centerAtLatLng</b>(<a href="#GPoint">GPoint</a>)<br />&nbsp;&nbsp;&nbsp;
					マップの中央の座標を引数の示す座標に移動</td></tr>
		<tr><td>void</td><td><b>recenterOrPanToLatLng</b>(<a href="#GPoint">GPoint</a>)<br />&nbsp;&nbsp;&nbsp;
					マップの中央の座標を引数の示す座標に移動<br />
					(表示域内の移動であれば画面切り替えせずにスムーズに移動する)</td></tr>
		<tr><td>void</td><td><b>zoomTo</b>(int)<br />&nbsp;&nbsp;&nbsp;
					マップのズームレベルを切り替える<br />
					(マップタイプが対応しているズームレベル以外の場合は無視する)</td></tr>
		<tr><td>void</td><td><b>centerAndZoom</b>(<a href="#GPoint">GPoint</a>, int)<br />&nbsp;&nbsp;&nbsp;
					マップの中央座標、ズームを自動的に設定する(初期画面表示の際に使用)</td></tr>
		<tr><td>int[]</td><td><b>getMapTypes</b>()<br />&nbsp;&nbsp;&nbsp;
					サポートされているマップ種類の配列を返す(例: G_MAP_TYPE and G_SATELLITE_TYPE)</td></tr>
		<tr><td>int</td><td><b>getCurrentMapType</b>()<br />&nbsp;&nbsp;&nbsp;
					現在のマップ種類を返す(例: G_MAP_TYPE or G_SATELLITE_TYPE)</td></tr>
		<tr><td>void</td><td><b>setMapType</b>(int)<br />&nbsp;&nbsp;&nbsp;
					マップ種類を切り替える(例: G_MAP_TYPE or G_SATELLITE_TYPE)</td></tr>
		<tr><td>void</td><td><b>addOverlay</b>(overlay)<br />&nbsp;&nbsp;&nbsp;
					マップにoverlayオブジェクトを追加する(例: <a href="#GMarker">GMarker</a> or <a href="#GPolyline">GPolyline</a>)</td></tr>
		<tr><td>void</td><td><b>removeOverlay</b>(overlay)<br />&nbsp;&nbsp;&nbsp;
					マップからoverlayオブジェクトを除去する</td></tr>
		<tr><td>void</td><td><b>clearOverlays</b>()<br />&nbsp;&nbsp;&nbsp;
					マップ上のすべてのoverlayオブジェクトを除去する</td></tr>
		<tr><td>void</td><td><b>openInfoWindow</b>(<a href="#GPoint">GPoint</a>, htmlElem, pixelOffset?, onOpenFn?, onCloseFn?)<br />&nbsp;&nbsp;&nbsp;
					指定座標に吹き出しを表示する</td></tr>
		<tr><td>void</td><td><b>openInfoWindowHtml</b>(<a href="#GMarker">GMarker</a>, htmlStr, pixelOffset?, onOpenFn?, onCloseFn?)<br />&nbsp;&nbsp;&nbsp;
					指定座標に吹き出しを表示する</td></tr>
		<tr><td>void</td><td><b>openInfoWindowXslt</b>(<a href="#GMarker">GMarker</a>, xmlElem, xsltUri, pixelOffset?, onOpenFn?, onCloseFn?)<br />&nbsp;&nbsp;&nbsp;
					指定座標に吹き出しを表示する</td></tr>
		<tr><td>void</td><td><b>showMapBlowup</b>(<a href="#GPoint">GPoint</a>, zoomLevel?, mapType?, pixelOffset?, onOpenFn?, onCloseFn?)<br />&nbsp;&nbsp;&nbsp;
					マップを引き伸ばし表示する</td></tr>
		<tr><td>void</td><td><b>closeInfoWindow</b>()<br />&nbsp;&nbsp;&nbsp;
					吹き出しを閉じる</td></tr>
	</table>
	<table class="doc">
		<col width="120px" />
		<col />
		<tr>
			<th colspan="2">イベント</th>
		</tr>
		<tr><td>click</td><td>
					マップ、またはマップ上のオーバーレイオブジェクトをクリック<br />
					(オーバーレイ上であれば、オーバーレイ上のイベント処理を行い、<br />
					それ以外の場合は、マップ上のイベント処理を行う)</td></tr>
		<tr><td>move</td><td>
					マップの移動(マップをドラッグする際は、連続的に生じる)</td></tr>
		<tr><td>movestart</td><td>
					マップの移動開始(ドラッグ等の連続移動のときのみ)</td></tr>
		<tr><td>moveend</td><td>
					マップの移動終了(連続移動、不連続移動問わず)</td></tr>
		<tr><td>zoom</td><td>
					ズームの値変更</td></tr>
		<tr><td>maptypechanged</td><td>
					マップ種類変更</td></tr>
		<tr><td>infowindowopen</td><td>
					吹き出し表示</td></tr>
		<tr><td>infowindowclose</td><td>
					吹き出しを閉じる</td></tr>
		<tr><td>addoverlay</td><td>
					マップにオーバーレイを追加</td></tr>
		<tr><td>removeoverlay</td><td>
					マップからオーバーレイを除去(オーバーレイ一括除去の場合は除く)</td></tr>
		<tr><td>clearoverlays</td><td>
					マップからオーバーレイを一括除去</td></tr>
	</table>
	<div class="right"><a href="#top">Topへ</a></div>
<!-- GMarker //-->
	<a name="GMarker"><div class="docTitle">GMarker</div></a>
	<table class="doc">
		<tr>
			<th>コンストラクタ</th>
		</tr>
		<tr>
			<td>
				<b>GMarker</b>(<a href="#GPoint">GPoint</a>, icon?)
			</td>
		</tr>
	</table>
	<table class="doc">
		<col width="120px" />
		<col />
		<tr>
			<th colspan="2">メソッド</th>
		</tr>
		<tr><td>void</td><td><b>openInfoWindow</b>(htmlElem)<br />&nbsp;&nbsp;&nbsp;
						吹き出しを表示する</td></tr>
		<tr><td>void</td><td><b>openInfoWindowHtml</b>(htmlStr)<br />&nbsp;&nbsp;&nbsp;
						吹き出しを表示する</td></tr>
		<tr><td>void</td><td><b>openInfoWindowXslt</b>(xmlElem, xsltUri)<br />&nbsp;&nbsp;&nbsp;
						吹き出しを表示する</td></tr>
		<tr><td>void</td><td><b>showMapBlowup</b>(zoomLevel?, mapType?)<br />&nbsp;&nbsp;&nbsp;
					マップを引き伸ばし表示する</td></tr>
	</table>
	<table class="doc">
		<col width="120px" />
		<col />
		<tr>
			<th colspan="2">イベント</th>
		</tr>
		<tr><td>click</td><td>マーカーをクリック</td></tr>
		<tr><td>infowindowopen</td><td>	吹き出し表示</td></tr>
		<tr><td>infowindowclose</td><td>吹き出しを閉じる</td></tr>
	</table>
	<div class="right"><a href="#top">Topへ</a></div>
<!-- GPolyline //-->
	<a name="GPolyline"><div class="docTitle">GPolyline</div></a>
	<table class="doc">
		<tr>
			<th>コンストラクタ</th>
		</tr>
		<tr>
			<td>
				<b>GPolyline</b>(<a href="#GPoint">GPoint</a>[], color?, weight?, opacity?)<br />&nbsp;&nbsp;&nbsp;
				points:		GPoint配列<br />&nbsp;&nbsp;&nbsp;
				color:		(例: #ffffff)<br />&nbsp;&nbsp;&nbsp;
				weight:		描画する線の幅(単位はpx)<br />&nbsp;&nbsp;&nbsp;
				opacity:	透明度(0 - 1 の間の数値を指定)<br />&nbsp;&nbsp;&nbsp;
			</td>
		</tr>
	</table>
	<div class="right"><a href="#top">Topへ</a></div>
<!-- GIcon //-->
	<a name="GIcon"><div class="docTitle">GIcon</div></a>
	<table class="doc">
		<tr>
			<th>コンストラクタ</th>
		</tr>
		<tr>
			<td>
				<b>GIcon</b>(copy?)
			</td>
		</tr>
	</table>
	<table class="doc">
		<col width="120px" />
		<col />
		<tr>
			<th colspan="2">プロパティ</th>
		</tr>
		<tr><td>image</td><td>アイコンイメージのURL</td></tr>
		<tr><td>shadow</td><td>シャドーイメージのURL</td></tr>
		<tr><td>iconSize</td><td>アイコンイメージのサイズ(px)</td></tr>
		<tr><td>shadowSize</td><td>シャドーイメージのサイズ(px)</td></tr>
		<tr><td>iconAnchor</td><td></td></tr>
		<tr><td>infoWindowAnchor</td><td></td></tr>
		<tr><td>printImage</td><td></td></tr>
		<tr><td>mozPrintImage</td><td></td></tr>
		<tr><td>printShadow</td><td></td></tr>
		<tr><td>transparent</td><td></td></tr>
		<tr><td>imageMap</td><td></td></tr>
	</table>
	<div class="right"><a href="#top">Topへ</a></div>
<!-- GPoint //-->
	<a name="GPoint"><div class="docTitle">GPoint</div></a>
	<table class="doc">
		<tr>
			<th>コンストラクタ</th>
		</tr>
		<tr>
			<td>
				<b>GPoint</b>(x, y)
			</td>
		</tr>
	</table>
	<table class="doc">
		<col width="120px" />
		<col />
		<tr>
			<th colspan="2">プロパティ</th>
		</tr>
		<tr><td>x</td><td>経度</td></tr> 
		<tr><td>y</td><td>緯度</td></tr>
	</table>
	<div class="right"><a href="#top">Topへ</a></div>
<!-- GSize //-->
	<a name="GSize"><div class="docTitle">GSize</div></a>
	<table class="doc">
		<tr>
			<th>コンストラクタ</th>
		</tr>
		<tr>
			<td>
				<b>GSize</b>(width, height)
			</td>
		</tr>
	</table>
	<table class="doc">
		<col width="120px" />
		<col />
		<tr>
			<th colspan="2">プロパティ</th>
		</tr>
		<tr><td>width</td><td>幅</td></tr> 
		<tr><td>height</td><td>高さ</td></tr>
	</table>
	<div class="right"><a href="#top">Topへ</a></div>
<!-- GBounds //-->
	<a name="GBounds"><div class="docTitle">GBounds</div></a>
	<table class="doc">
		<tr>
			<th>コンストラクタ</th>
		</tr>
		<tr>
			<td>
				<b>GBounds</b>(minX, minY, maxX, maxY)
			</td>
		</tr>
	</table>
	<table class="doc">
		<col width="120px" />
		<col />
		<tr>
			<th colspan="2">プロパティ</th>
		</tr>
		<tr><td>minX</td><td>領域左上のX座標(経度)</td></tr> 
		<tr><td>minY</td><td>領域左上のY座標(緯度)</td></tr>
		<tr><td>maxX</td><td>領域右下のX座標(経度)</td></tr> 
		<tr><td>maxY</td><td>領域右下のY座標(緯度)</td></tr>
	</table>
	<div class="right"><a href="#top">Topへ</a></div>
<!-- GEvent //-->
	<a name="GEvent"><div class="docTitle">GEvent</div></a>
	<table class="doc">
		<col width="120px" />
		<col />
		<tr>
			<th colspan="2">スタティックメソッド</th>
		</tr>
		<tr><td>void</td><td><b>addListener</b>(source, eventName, listenerFn)<br />&nbsp;&nbsp;&nbsp;イベントリスナーの追加</td></tr>
		<tr><td>void</td><td><b>removeListener</b>(listener)<br />&nbsp;&nbsp;&nbsp;イベントリスナーの除去</td></tr>
		<tr><td>void</td><td><b>clearListeners</b>(source, eventName)<br />&nbsp;&nbsp;&nbsp;イベントリスナーの一括除去</td></tr>
		<tr><td>void</td><td><b>trigger</b>(source, eventName, args...)<br />&nbsp;&nbsp;&nbsp;イベントを引き起こす</td></tr>
		<tr><td>void</td><td><b>bind</b>(source, eventName, object, method)<br />&nbsp;&nbsp;&nbsp;</td></tr>
	</table>
	<div class="right"><a href="#top">Topへ</a></div>
<!-- GXmlHttp //-->
	<a name="GXmlHttp"><div class="docTitle">GXmlHttp</div></a>
	<table class="doc">
		<col width="120px" />
		<col />
		<tr>
			<th colspan="2">スタティックメソッド</th>
		</tr>
		<tr><td>XmlHttpRequest</td><td><b>create</b>()<br />&nbsp;&nbsp;&nbsp;XmlHttpRequestインスタンスを生成</td></tr>
	</table>
	<div class="right"><a href="#top">Topへ</a></div>

<!-- GXml //-->
	<a name="GXml"><div class="docTitle">GXml</div></a>
	<table class="doc">
		<col width="120px" />
		<col />
		<tr>
			<th colspan="2">スタティックメソッド</th>
		</tr>
		<tr><td>XMLDom</td><td><b>parse</b>(xmlStr)<br />&nbsp;&nbsp;&nbsp;文字列をXML DOMに変換</td></tr>
		<tr><td>String</td><td><b>value</b>(xmlNode)<br />&nbsp;&nbsp;&nbsp;指定ノードの値を文字列で返す</td></tr>
	</table>
	<div class="right"><a href="#top">Topへ</a></div>

<!-- GXslt //-->
	<a name="GXslt"><div class="docTitle">GXslt</div></a>
	<table class="doc">
		<col width="120px" />
		<col />
		<tr>
			<th colspan="2">スタティックメソッド</th>
		</tr>
		<tr><td>GXslt</td><td><b>create</b>(xsltXmlDoc)<br />&nbsp;&nbsp;&nbsp;GXsltインスタンスを生成</td></tr>
	</table>
	<table class="doc">
		<col width="120px" />
		<col />
		<tr>
			<th colspan="2">メソッド</th>
		</tr>
		<tr><td>HTML DOM</td><td><b>transformToHtml</b>(xmlDoc, htmlContainer)<br />&nbsp;&nbsp;&nbsp;
					XSLTを利用してXMLドキュメントをHTML DOM に変換</td></tr>
	</table>
	<div class="right"><a href="#top">Topへ</a></div>
	
<!-- GSmallMapControl //-->
	<a name="GSmallMapControl"><div class="docTitle">GSmallMapControl</div></a>
	<div class="docContents">マップ左上の移動およびズームコントロール(small version)</div>
	<table class="doc">
		<tr>
			<th>コンストラクタ</th>
		</tr>
		<tr>
			<td>
				<b>GSmallMapControl</b>()
			</td>
		</tr>
	</table>
	<div class="right"><a href="#top">Topへ</a></div>
<!-- GLargeMapControl //-->
	<a name="GLargeMapControl"><div class="docTitle">GLargeMapControl</div></a>
	<div class="docContents">マップ左上の移動およびズームコントロール(large version)</div>
	<table class="doc">
		<tr>
			<th>コンストラクタ</th>
		</tr>
		<tr>
			<td>
				<b>GLargeMapControl</b>()
			</td>
		</tr>
	</table>
	<div class="right"><a href="#top">Topへ</a></div>
<!-- GMapTypeControl //-->
	<a name="GMapTypeControl"><div class="docTitle">GMapTypeControl</div></a>
	<div class="docContents">マップ右上の種別切り替えコントロール(マップ、サテライト、デュアル)</div>
	<table class="doc">
		<tr>
			<th>コンストラクタ</th>
		</tr>
		<tr>
			<td>
				<b>GMapTypeControl</b>()
			</td>
		</tr>
	</table>
	<div class="right"><a href="#top">Topへ</a></div>
<!-- GScaleControl //-->
	<a name="GScaleControl"><div class="docTitle">GScaleControl</div></a>
	<div class="docContents">マップ左下の縮尺</div>
	<table class="doc">
		<tr>
			<th>コンストラクタ</th>
		</tr>
		<tr>
			<td>
				<b>GScaleControl</b>()
			</td>
		</tr>
	</table>
	<div class="right"><a href="#top">Topへ</a></div>
</div>
<div id="frame2Left">
	<div class="left">
		<a href="#GMap">GMap</a><br />
		<a href="#GMarker">GMarker</a><br />
		<a href="#GPolyline">GPolyline</a><br />
		<a href="#GIcon">GIcon</a><br />
		<a href="#GPoint">GPoint</a><br />
		<a href="#GSize">GSize</a><br />
		<a href="#GBounds">GBounds</a><br />
		
		<a href="#GEvent">GEvent</a><br />
		<a href="#GXmlHttp">GXmlHttp</a><br />
		<a href="#GXml">GXml</a><br />
		<a href="#GXslt">GXslt</a><br />
		<a href="#GSmallMapControl">GSmallMapControl</a><br />
		<a href="#GLargeMapControl">GLargeMapControl</a><br />
		<a href="#GMapTypeControl">GMapTypeControl</a><br />
		<a href="#GScaleControl">GScaleControl</a><br />
	</div>
</div>