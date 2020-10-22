function newFileFolder(type){
	if(type=="folder"){
		$('a#new_folder').replaceWith($('<input type="text" name="new_folder" placeholder="Folder name...">' + '</input>'));
	} else {
		$('a#new_file').replaceWith($('<input type="text" name="new_file" placeholder="File name..."></input>'));
	}
	$('a#up').replaceWith($('<button type="submit">Create</button>'));
}

function renameButton(button){
	$('input[name="' + button + '"]').replaceWith($('<input type="text" name="r" placeholder="New name...">' + '</input>'));
}
function showButtons(button){
	$('span.hidden_babe2').replaceWith($('<input name="file_name" value="'+ button +'" style="display: none;"></input>'));
	$('span.hidden_babe').replaceWith($('<button type="submit" name="submit_form" placeholder="Hi guys!">SAVE</button>'));
}