/**
 * リンクの処理クラス。
 */
 class Link {
	/**
	 * リンクを設定します。
	 * @param {Array} list リンク情報。
	 */
	init(list) {
		console.log("init");
		for (let i = 0; i < list.length; i++) {
			console.log(list[i][0] + "," + list[i][1] + "," + list[i][2]);
			$("div#" + list[i][0] + " tspan").each((_, el) => {
				console.log("text=" + $(el).text());
				let t = $(el).text();
				if (list[i][1] == t) {
					$(el).css("cursor", "pointer");
					$(el).click(() => {
						window.location.href = list[i][2] + ".html";
					});
				}
			});
		}
	}
 }