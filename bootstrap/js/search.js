(function(window){

	// get vars
	var searchEl = document.querySelector("#input");
	var labelEl = document.querySelector("#label");
	var advanced = document.querySelector("#advanced");
	var menuEl = document.querySelector("#menu-button");

	// register clicks and toggle classes
	labelEl.addEventListener("click",function(){
		if (classie.has(searchEl,"focus")) {
			if(document.querySelector("#search-terms").value == null);
				document.querySelector("#search").submit();
			//classie.remove(searchEl,"focus");
			//classie.remove(labelEl,"active");
			//classie.remove(advanced,"focus");
		} else {
			classie.add(searchEl,"focus");
			classie.add(labelEl,"active");
			classie.add(advanced,"focus");
		}
	});
	
	menuEl.addEventListener("click",function(){
		if (classie.has(menuEl,"focus")) {
			classie.remove(menuEl,"focus");
		} else {
			classie.add(menuEl,"focus");
		}
	});

	// register clicks outisde search box, and toggle correct classes
	document.addEventListener("click",function(e){
		var clickedID = e.target.id;
		if (clickedID != "search-terms" && clickedID != "search-label" && clickedID != "advanced") {
			if (classie.has(searchEl,"focus")) {
				classie.remove(searchEl,"focus");
				classie.remove(labelEl,"active");
				classie.remove(advanced,"focus");
			}
		}
	});
	
}(window));