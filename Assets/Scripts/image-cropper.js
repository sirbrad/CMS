define(function(){

	var _project = '/GitHub/CMS/';
	
	// Size of image shown in crop tool
	var crop_imageWidth = 420;
	var crop_imageHeight = 336;

	// Size of original image
	var crop_originalImageWidth = 600;
	var crop_originalImageHeight = 450;

	var crop_minimumPercent = 10;	// Minimum percent - resize
	var crop_maximumPercent = 200;	// Maximum percent -resize

	var crop_minimumWidthHeight = 15;	// Minimum width and height of crop area

	var updateFormValuesAsYouDrag = true;	// This variable indicates if form values should be updated as we drag. This process could make the script work a little bit slow. That's why this option is set as a variable.
	if (!document.all) {
		updateFormValuesAsYouDrag = false;	// Enable this feature only in IE
	}

	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	var cropToolBorderWidth = 1, // Width of dotted border around crop rectangle
		smallSquareWidth = 7, // Size of small squares used to resize crop rectangle
		crop_script_alwaysPreserveAspectRatio = false,
		crop_script_fixedRatio = false, // Fixed aspect ratio(example of value: 1.5). Width of cropping area relative to height(1.5 means that the width is 150% of the height. Set this variable to false if you don't want a fixed aspect ratio 
		crop_script_browserIsOpera = navigator.userAgent.indexOf('Opera') >= 0 ? true : false,
		cropDiv_left = false,
		cropDiv_top = false,
		cropDiv_right = false,
		cropDiv_bottom = false,
		cropDiv_dotted = false,
		crop_currentResizeType = false,
		cropEvent_posX,
		cropEvent_posY,
		cropEvent_eventX,
		cropEvent_eventY,
		crop_resizeCounter = -1,
		crop_moveCounter = -1,
		crop_imageDiv = false,
		imageDiv_currentWidth = false,
		imageDiv_currentHeight = false,
		imageDiv_currentLeft = false,
		imageDiv_currentTop = false,
		smallSquare_tl,
		smallSquare_tc,
		smallSquare_tr,
		smallSquare_lc,
		smallSquare_rc,
		smallSquare_bl,
		smallSquare_bc,
		smallSquare_br,
		offsetSmallSquares = Math.floor(smallSquareWidth / 2),
		cropScriptAjaxObjects = [],
		preserveAspectRatio = false,
		cropWidthRatio = false; // width of cropping area relative to height

	function crop_createDivElements() {
		crop_imageDiv = document.getElementById('imageContainer');
		cropDiv_left = document.createElement('DIV');
		cropDiv_left.className = 'crop_transparentDiv';
		cropDiv_left.style.visibility = 'visible';
		cropDiv_left.style.left = '0px';
		cropDiv_left.style.top = '0px';
		cropDiv_left.style.height = crop_imageHeight + 'px';
		cropDiv_left.style.width = '0px';
		cropDiv_left.innerHTML = '<span></span>';
		crop_imageDiv.appendChild(cropDiv_left);

		cropDiv_top = document.createElement('DIV');
		cropDiv_top.className = 'crop_transparentDiv';
		cropDiv_top.style.visibility = 'visible';
		cropDiv_top.style.left = '0px';
		cropDiv_top.style.top = '0px';
		cropDiv_top.style.height = '0px';
		cropDiv_top.style.width = crop_imageWidth + 'px';
		cropDiv_top.innerHTML = '<span></span>';

		crop_imageDiv.appendChild(cropDiv_top);
		cropDiv_right = document.createElement('DIV');
		cropDiv_right.className = 'crop_transparentDiv';
		cropDiv_right.style.visibility = 'visible';
		cropDiv_right.style.left = (crop_imageWidth) + 'px';
		cropDiv_right.style.top = '0px';
		cropDiv_right.style.height = crop_imageHeight + 'px';
		cropDiv_right.style.width = '0px';
		cropDiv_right.innerHTML = '<span></span>';

		crop_imageDiv.appendChild(cropDiv_right);
		cropDiv_bottom = document.createElement('DIV');
		cropDiv_bottom.className = 'crop_transparentDiv';
		cropDiv_bottom.style.visibility = 'visible';
		cropDiv_bottom.style.left = '0px';
		cropDiv_bottom.style.top = (crop_imageHeight) + 'px';
		cropDiv_bottom.style.height = '0px';
		cropDiv_bottom.style.width = crop_imageWidth + 'px';
		cropDiv_bottom.innerHTML = '<span></span>';
		crop_imageDiv.appendChild(cropDiv_bottom);

		cropDiv_dotted = document.createElement('DIV');
		cropDiv_dotted.className = 'crop_dottedDiv';
		cropDiv_dotted.style.left = '0px';
		cropDiv_dotted.style.top = '0px';
		cropDiv_dotted.style.width = (crop_imageWidth - (cropToolBorderWidth * 2)) + 'px';
		cropDiv_dotted.style.height = (crop_imageHeight - (cropToolBorderWidth * 2)) + 'px';
		cropDiv_dotted.innerHTML = '<div></div>';
		cropDiv_dotted.style.cursor = 'move';

		if (crop_script_browserIsOpera) {
			var div = cropDiv_dotted.getElementsByTagName('DIV')[0];
			div.style.backgroundColor = 'transparent';
			cropDiv_bottom.style.backgroundColor = 'transparent';
			cropDiv_right.style.backgroundColor = 'transparent';
			cropDiv_top.style.backgroundColor = 'transparent';
			cropDiv_left.style.backgroundColor = 'transparent';
		}

		cropDiv_dotted.onmousedown = cropScript_initMove;

		smallSquare_tl = document.createElement('IMG');
		smallSquare_tl.src = _project+'Assets/Images/Core/small_square.gif';
		smallSquare_tl.style.position = 'absolute';
		smallSquare_tl.style.left = (-offsetSmallSquares - (cropToolBorderWidth * 2)) + 'px';
		smallSquare_tl.style.top = (-offsetSmallSquares - (cropToolBorderWidth * 2)) + 'px';
		smallSquare_tl.style.cursor = 'nw-resize';
		smallSquare_tl.id = 'nw-resize';
		smallSquare_tl.onmousedown = cropScript_initResize;
		cropDiv_dotted.appendChild(smallSquare_tl);

		smallSquare_tr = document.createElement('IMG');
		smallSquare_tr.src = _project+'Assets/Images/Core/small_square.gif';
		smallSquare_tr.style.position = 'absolute';
		smallSquare_tr.style.left = (crop_imageWidth - offsetSmallSquares - (cropToolBorderWidth * 2)) + 'px';
		smallSquare_tr.style.top = (-offsetSmallSquares - (cropToolBorderWidth * 2)) + 'px';
		smallSquare_tr.style.cursor = 'ne-resize';
		smallSquare_tr.id = 'ne-resize';
		smallSquare_tr.onmousedown = cropScript_initResize;
		cropDiv_dotted.appendChild(smallSquare_tr);

		smallSquare_bl = document.createElement('IMG');
		smallSquare_bl.src = _project+'Assets/Images/Core/small_square.gif';
		smallSquare_bl.style.position = 'absolute';
		smallSquare_bl.style.left = (-offsetSmallSquares - (cropToolBorderWidth * 2)) + 'px';
		smallSquare_bl.style.top = (crop_imageHeight - offsetSmallSquares - (cropToolBorderWidth * 2)) + 'px';
		smallSquare_bl.style.cursor = 'sw-resize';
		smallSquare_bl.id = 'sw-resize';
		smallSquare_bl.onmousedown = cropScript_initResize;
		cropDiv_dotted.appendChild(smallSquare_bl);

		smallSquare_br = document.createElement('IMG');
		smallSquare_br.src = _project+'Assets/Images/Core/small_square.gif';
		smallSquare_br.style.position = 'absolute';
		smallSquare_br.style.left = (crop_imageWidth - offsetSmallSquares - (cropToolBorderWidth * 2)) + 'px';
		smallSquare_br.style.top = (crop_imageHeight - offsetSmallSquares - (cropToolBorderWidth * 2)) + 'px';
		smallSquare_br.style.cursor = 'se-resize';
		smallSquare_br.id = 'se-resize';
		smallSquare_br.onmousedown = cropScript_initResize;
		cropDiv_dotted.appendChild(smallSquare_br);

		smallSquare_tc = document.createElement('IMG');
		smallSquare_tc.src = _project+'Assets/Images/Core/small_square.gif';
		smallSquare_tc.style.position = 'absolute';
		smallSquare_tc.style.left = (Math.floor(crop_imageWidth / 2) - offsetSmallSquares - (cropToolBorderWidth * 2)) + 'px';
		smallSquare_tc.style.top = (-offsetSmallSquares - (cropToolBorderWidth * 2)) + 'px';
		smallSquare_tc.style.cursor = 's-resize';
		smallSquare_tc.id = 'n-resize';
		smallSquare_tc.onmousedown = cropScript_initResize;
		cropDiv_dotted.appendChild(smallSquare_tc);

		smallSquare_bc = document.createElement('IMG');
		smallSquare_bc.src = _project+'Assets/Images/Core/small_square.gif';
		smallSquare_bc.style.position = 'absolute';
		smallSquare_bc.style.left = (Math.floor(crop_imageWidth / 2) - offsetSmallSquares - (cropToolBorderWidth * 2)) + 'px';
		smallSquare_bc.style.top = (crop_imageHeight - offsetSmallSquares - (cropToolBorderWidth * 2)) + 'px';
		smallSquare_bc.style.cursor = 's-resize';
		smallSquare_bc.id = 's-resize';
		smallSquare_bc.onmousedown = cropScript_initResize;
		cropDiv_dotted.appendChild(smallSquare_bc);

		smallSquare_lc = document.createElement('IMG');
		smallSquare_lc.src = _project+'Assets/Images/Core/small_square.gif';
		smallSquare_lc.style.position = 'absolute';
		smallSquare_lc.style.left = (-offsetSmallSquares - (cropToolBorderWidth * 2)) + 'px';
		smallSquare_lc.style.top = (Math.floor(crop_imageHeight / 2) - offsetSmallSquares - (cropToolBorderWidth * 2)) + 'px';
		smallSquare_lc.style.cursor = 'e-resize';
		smallSquare_lc.id = 'w-resize';
		smallSquare_lc.onmousedown = cropScript_initResize;
		cropDiv_dotted.appendChild(smallSquare_lc);

		smallSquare_rc = document.createElement('IMG');
		smallSquare_rc.src = _project+'Assets/Images/Core/small_square.gif';
		smallSquare_rc.style.position = 'absolute';
		smallSquare_rc.style.left = (crop_imageWidth - offsetSmallSquares - (cropToolBorderWidth * 2)) + 'px';
		smallSquare_rc.style.top = (Math.floor(crop_imageHeight / 2) - offsetSmallSquares - (cropToolBorderWidth * 2)) + 'px';
		smallSquare_rc.style.cursor = 'e-resize';
		smallSquare_rc.id = 'e-resize';
		smallSquare_rc.onmousedown = cropScript_initResize;
		cropDiv_dotted.appendChild(smallSquare_rc);
		crop_imageDiv.appendChild(cropDiv_dotted);
	}

	function cropScript_initMove(e) {
		if (document.all) { 
			e = event;
		}

		if (e.target) { 
			source = e.target;
		} else if (e.srcElement) { 
			source = e.srcElement; 
		}

		if (source.nodeType == 3) { // defeat Safari bug
			source = source.parentNode;
		}

		if (source.id && source.id.indexOf('resize') >= 0) {
			return;
		}

		imageDiv_currentLeft = cropDiv_dotted.style.left.replace('px', '') / 1;
		imageDiv_currentTop = cropDiv_dotted.style.top.replace('px', '') / 1;
		imageDiv_currentWidth = cropDiv_dotted.style.width.replace('px', '') / 1;
		imageDiv_currentHeight = cropDiv_dotted.style.height.replace('px', '') / 1;

		cropEvent_eventX = e.clientX;
		cropEvent_eventY = e.clientY;

		crop_moveCounter = 0;

		cropScript_timerMove();

		return false;
	}

	function cropScript_timerMove() {
		if (crop_moveCounter >= 0 && crop_moveCounter < 10) {
			crop_moveCounter++;
			setTimeout(function(){
				cropScript_timerMove();
			}, 1);
			return;
		}
	}

	function cropScript_initResize(e) {
		if (document.all) {
			e = event;
		}

		cropDiv_dotted.style.cursor = 'default';
		crop_currentResizeType = this.id;
		cropEvent_eventX = e.clientX;
		cropEvent_eventY = e.clientY;
		crop_resizeCounter = 0;

		imageDiv_currentWidth = cropDiv_dotted.style.width.replace('px', '') / 1;
		imageDiv_currentHeight = cropDiv_dotted.style.height.replace('px', '') / 1;
		imageDiv_currentLeft = cropDiv_dotted.style.left.replace('px', '') / 1;
		imageDiv_currentTop = cropDiv_dotted.style.top.replace('px', '') / 1;

		cropWidthRatio = cropDiv_dotted.offsetWidth / cropDiv_dotted.offsetHeight;

		if (crop_script_fixedRatio) {
			cropWidthRatio = crop_script_fixedRatio;
		}

		if (document.all) {
			var div = cropDiv_dotted.getElementsByTagName('DIV')[0];
			div.style.display = 'none';
		}

		cropScript_timerResize();

		return false;
	}

	function cropScript_timerResize() {
		if (crop_resizeCounter >= 0 && crop_resizeCounter < 10) {
			crop_resizeCounter = crop_resizeCounter + 1;
			setTimeout(function(){
				cropScript_timerResize();
			}, 1);
			return;
		}
	}

	function cropScript_cropCompleted(ajaxIndex, buttonObj) {
		buttonObj.style.visibility = '';
		eval(cropScriptAjaxObjects[ajaxIndex].response)
		cropScriptAjaxObjects[ajaxIndex] = false;
		crop_hideProgressBar();
	}

	function crop_cancelEvent(e) {
		if (document.all) { 
			e = event; 
		}

		if (e.target) {
			source = e.target;
		} else if (e.srcElement) {
			source = e.srcElement;
		}

		if (source.nodeType == 3) { // defeat Safari bug
			source = source.parentNode;
		}

		if (source.tagName && source.tagName.toLowerCase() == 'input') {
			return true;
		}

		return false;
	}

	var mouseMoveEventInProgress = false;

	function getAdjustedCoordinates(coordinates, currentCoordinates, aspectRatio, currentResize) {
		currentResize = currentResize.replace('-resize', '');
		var minWidth = aspectRatio ? crop_minimumWidthHeight * aspectRatio : crop_minimumWidthHeight;
		var minHeight = aspectRatio ? crop_minimumWidthHeight / aspectRatio : crop_minimumWidthHeight;

		if (coordinates.left + coordinates.width + 2 > crop_imageWidth) {
			coordinates.width = crop_imageWidth - coordinates.left - 2;
		}

		if (coordinates.top + coordinates.height + 2 > crop_imageHeight) {
			coordinates.height = crop_imageHeight - coordinates.top - 2;
		}

		if (coordinates.height < minHeight) {
			coordinates.height = currentCoordinates.height;
			coordinates.top = currentCoordinates.top;
		}

		if (coordinates.width < minWidth) {
			coordinates.width = currentCoordinates.width;
			coordinates.left = currentCoordinates.left;
		}

		if (aspectRatio) {
			var currentRatio = coordinates.width / coordinates.height;

			switch (currentResize) {
				case 'n':
					// Height is being resized - set new left coordinate
					var newWidth = Math.round(coordinates.height * aspectRatio);
					coordinates.left += (coordinates.width - newWidth);
					coordinates.width = newWidth;
					break;
				case 'w':
				case 'nw':
				case 'ne':
					// Width is being resized - Set new top coordinate
					var newHeight = Math.round(coordinates.width / aspectRatio);
					coordinates.top += (coordinates.height - newHeight);
					coordinates.height = newHeight;
					break;
				case 'e':
				case 'se':
					coordinates.height = Math.round(coordinates.width / aspectRatio);
					break;
				case 's':
					coordinates.width = Math.round(coordinates.height * aspectRatio);
					break;
				default:
			}

			if (coordinates.left < 0) {
				coordinates.width += coordinates.left;
				coordinates.height = coordinates.width / aspectRatio;
				coordinates.left = 0;
			}

			if (coordinates.top < 0) {
				var origWidth = coordinates.width;
				coordinates.height += coordinates.top;
				coordinates.width = coordinates.height * aspectRatio;
				coordinates.top = 0;

				if (currentResize == 'nw') {
					coordinates.left += (origWidth - coordinates.width);
				}
			}

			if (coordinates.width < minWidth) {
				coordinates.width = minWidth;
				coordinates.height = coordinates.width / aspectRatio;
			}

			if (coordinates.height < minHeight) {
				coordinates.height = minHeight;
				coordinates.width = coordinates.height * aspectRatio;
			}

			if (coordinates.left + coordinates.width + 2 > crop_imageWidth) {
				coordinates.width = crop_imageWidth - coordinates.left - 2;
				coordinates.height = Math.round(coordinates.width / aspectRatio)
			}

			if (coordinates.top + coordinates.height + 2 > crop_imageHeight) {
				coordinates.height = crop_imageHeight - coordinates.top - 2;
				coordinates.width = Math.round(coordinates.height * aspectRatio)
			}
		}

		if (coordinates.height < minHeight) {
			coordinates.height = currentCoordinates.height;
			coordinates.top = currentCoordinates.top;
		}

		if (coordinates.width < minWidth) {
			coordinates.width = currentCoordinates.width;
			coordinates.left = currentCoordinates.left;
		}

		return coordinates;
	}

	function cropScript_mouseMove(e) {
		if (crop_moveCounter < 10 && crop_resizeCounter < 10) {
			return;
		}

		if (mouseMoveEventInProgress) {
			return;
		}

		if (document.all) {
			mouseMoveEventInProgress = true;
		}

		if (document.all) {
			e = event;
		}

		if (crop_resizeCounter == 10) {
			var cropStyleObj = cropDiv_dotted.style;

			if (e.ctrlKey || crop_script_alwaysPreserveAspectRatio) {
				preserveAspectRatio = true;
			} else {
				preserveAspectRatio = false;
			}

			var currentCoordinates = {
				left: cropStyleObj.left.replace('px', '') / 1,
				top: cropStyleObj.top.replace('px', '') / 1,
				width: cropDiv_dotted.clientWidth,
				height: cropDiv_dotted.clientHeight
			}

			// crop_imageHeight = max y
			// crop_imageWidth = max x

			var newCoordinates = {};
			newCoordinates.left = currentCoordinates.left;
			newCoordinates.top = currentCoordinates.top;
			newCoordinates.width = currentCoordinates.width;
			newCoordinates.height = currentCoordinates.height;

			if (crop_currentResizeType == 'e-resize' || crop_currentResizeType == 'ne-resize' || crop_currentResizeType == 'se-resize') { /* East resize */
				newCoordinates.width = Math.max(crop_minimumWidthHeight, (imageDiv_currentWidth + e.clientX - cropEvent_eventX));
			}

			if (crop_currentResizeType == 's-resize' || crop_currentResizeType == 'sw-resize' || crop_currentResizeType == 'se-resize') {
				newCoordinates.height = Math.max(crop_minimumWidthHeight, (imageDiv_currentHeight + e.clientY - cropEvent_eventY));
			}

			if (crop_currentResizeType == 'n-resize' || crop_currentResizeType == 'nw-resize' || crop_currentResizeType == 'ne-resize') {
				var newTop = Math.max(0, (imageDiv_currentTop + e.clientY - cropEvent_eventY));
				newCoordinates.height += (currentCoordinates.top - newTop);
				newCoordinates.top = newTop;
			}

			if (crop_currentResizeType == 'w-resize' || crop_currentResizeType == 'sw-resize' || crop_currentResizeType == 'nw-resize') {
				var newLeft = Math.max(0, (imageDiv_currentLeft + e.clientX - cropEvent_eventX));
				newCoordinates.width += (currentCoordinates.left - newLeft);
				newCoordinates.left = newLeft;
			}

			if (newCoordinates && (newCoordinates.left || newCoordinates.top || newCoordinates.width || newCoordinates.height)) {
				newCoordinates = getAdjustedCoordinates(newCoordinates, currentCoordinates, preserveAspectRatio ? cropWidthRatio : false, crop_currentResizeType);
			}

			if (newCoordinates) {
				cropStyleObj.left = newCoordinates.left + 'px';
				cropStyleObj.top = newCoordinates.top + 'px';
				cropStyleObj.width = newCoordinates.width + 'px';
				cropStyleObj.height = newCoordinates.height + 'px';
			}

			if (!crop_script_fixedRatio && !e.ctrlKey) {
				cropWidthRatio = cropDiv_dotted.offsetWidth / cropDiv_dotted.offsetHeight;
			}
		}

		if (crop_moveCounter == 10) {
			var tmpLeft = imageDiv_currentLeft + e.clientX - cropEvent_eventX;

			if (tmpLeft < 0) {
				tmpLeft = 0;
			}

			if ((tmpLeft + imageDiv_currentWidth + (cropToolBorderWidth * 2)) > crop_imageWidth) {
				tmpLeft = crop_imageWidth - imageDiv_currentWidth - (cropToolBorderWidth * 2);
			}

			cropDiv_dotted.style.left = tmpLeft + 'px';

			var tmpTop = imageDiv_currentTop + e.clientY - cropEvent_eventY;

			if (tmpTop < 0) {
				tmpTop = 0;
			}

			if ((tmpTop + imageDiv_currentHeight + (cropToolBorderWidth * 2)) > crop_imageHeight) {
				tmpTop = crop_imageHeight - imageDiv_currentHeight - (cropToolBorderWidth * 2);
			}

			cropDiv_dotted.style.top = tmpTop + 'px';
		}

		repositionSmallSquares();
		resizeTransparentSquares();

		if (updateFormValuesAsYouDrag) {
			cropScript_updateFormValues();
		}

		mouseMoveEventInProgress = false;
	}

	function repositionSmallSquares() {
		smallSquare_tc.style.left = (Math.floor((cropDiv_dotted.style.width.replace('px', '') / 1 + (cropToolBorderWidth * 2)) / 2) - offsetSmallSquares - (cropToolBorderWidth * 2)) + 'px';
		smallSquare_bc.style.left = (Math.floor((cropDiv_dotted.style.width.replace('px', '') / 1 + (cropToolBorderWidth * 2)) / 2) - offsetSmallSquares - (cropToolBorderWidth * 2)) + 'px';
		smallSquare_tr.style.left = (cropDiv_dotted.style.width.replace('px', '') / 1 + (cropToolBorderWidth * 2) - offsetSmallSquares - (cropToolBorderWidth * 2)) + 'px';
		smallSquare_rc.style.left = (cropDiv_dotted.style.width.replace('px', '') / 1 + (cropToolBorderWidth * 2) - offsetSmallSquares - (cropToolBorderWidth * 2)) + 'px';
		smallSquare_br.style.left = (cropDiv_dotted.style.width.replace('px', '') / 1 + (cropToolBorderWidth * 2) - offsetSmallSquares - (cropToolBorderWidth * 2)) + 'px';
		smallSquare_br.style.top = (cropDiv_dotted.style.height.replace('px', '') / 1 + (cropToolBorderWidth * 2) - offsetSmallSquares - (cropToolBorderWidth * 2)) + 'px';
		smallSquare_bc.style.top = (cropDiv_dotted.style.height.replace('px', '') / 1 + (cropToolBorderWidth * 2) - offsetSmallSquares - (cropToolBorderWidth * 2)) + 'px';
		smallSquare_bl.style.top = (cropDiv_dotted.style.height.replace('px', '') / 1 + (cropToolBorderWidth * 2) - offsetSmallSquares - (cropToolBorderWidth * 2)) + 'px';
		smallSquare_lc.style.top = (Math.floor((cropDiv_dotted.style.height.replace('px', '') / 1 + cropToolBorderWidth) / 2) - offsetSmallSquares - (cropToolBorderWidth * 2)) + 'px';
		smallSquare_rc.style.top = (Math.floor((cropDiv_dotted.style.height.replace('px', '') / 1 + cropToolBorderWidth) / 2) - offsetSmallSquares - (cropToolBorderWidth * 2)) + 'px';
	}

	function resizeTransparentSquares() {
		cropDiv_left.style.width = cropDiv_dotted.style.left;
		cropDiv_right.style.width = Math.max(0, crop_imageWidth - (cropToolBorderWidth * 2) - (cropDiv_dotted.style.width.replace('px', '') / 1 + cropDiv_dotted.style.left.replace('px', '') / 1)) + 'px';
		cropDiv_right.style.left = (cropDiv_dotted.style.width.replace('px', '') / 1 + (cropToolBorderWidth * 2) + cropDiv_dotted.style.left.replace('px', '') / 1) + 'px';
		cropDiv_bottom.style.height = Math.max(0, crop_imageHeight - (cropToolBorderWidth * 2) - (cropDiv_dotted.style.height.replace('px', '') / 1 + cropDiv_dotted.style.top.replace('px', '') / 1)) + 'px';
		cropDiv_bottom.style.top = (cropDiv_dotted.style.height.replace('px', '') / 1 + (cropToolBorderWidth * 2) + cropDiv_dotted.style.top.replace('px', '') / 1) + 'px';
		cropDiv_top.style.height = cropDiv_dotted.style.top;
		cropDiv_bottom.style.left = cropDiv_dotted.style.left;
		cropDiv_bottom.style.width = (cropDiv_dotted.style.width.replace('px', '') / 1 + (cropToolBorderWidth * 2)) + 'px';
		cropDiv_top.style.left = cropDiv_dotted.style.left;
		cropDiv_top.style.width = (cropDiv_dotted.style.width.replace('px', '') / 1 + (cropToolBorderWidth * 2)) + 'px';

		if (cropDiv_left.style.width == '0px') {
			cropDiv_left.style.visibility = 'hidden';
		} else {
			cropDiv_left.style.visibility = 'visible';
		}

		if (cropDiv_right.style.width == '0px') {
			cropDiv_right.style.visibility = 'hidden';
		} else {
			cropDiv_right.style.visibility = 'visible';
		}

		if (cropDiv_bottom.style.width == '0px') {
			cropDiv_bottom.style.visibility = 'hidden';
		} else {
			cropDiv_bottom.style.visibility = 'visible';
		}
	}

	function cropScript_updateFormValues() {
		document.getElementById('input_crop_x').value = Math.round(cropDiv_dotted.style.left.replace('px', '') / 1);
		document.getElementById('input_crop_y').value = Math.round(cropDiv_dotted.style.top.replace('px', '') / 1);
		document.getElementById('input_crop_width').value = Math.round((cropDiv_dotted.style.width.replace('px', '') / 1 + (cropToolBorderWidth * 2)));
		document.getElementById('input_crop_height').value = Math.round((cropDiv_dotted.style.height.replace('px', '') / 1 + (cropToolBorderWidth * 2)));
	}

	function cropScript_stopResizeMove() {
		crop_resizeCounter = -1;
		crop_moveCounter = -1;
		cropDiv_dotted.style.cursor = 'move';

		cropScript_updateFormValues();

		if (document.all) {
			var div = cropDiv_dotted.getElementsByTagName('DIV')[0];
			div.style.display = 'block';
		}
	}

	function cropScript_setCropSizeByInput() {
		var obj_x = document.getElementById('input_crop_x');
		var obj_y = document.getElementById('input_crop_y');
		var obj_width = document.getElementById('input_crop_width');
		var obj_height = document.getElementById('input_crop_height');

		obj_x.value = obj_x.value.replace(/[^0-9]/gi, '');
		obj_y.value = obj_y.value.replace(/[^0-9]/gi, '');
		obj_width.value = obj_width.value.replace(/[^0-9]/gi, '');
		obj_height.value = obj_height.value.replace(/[^0-9]/gi, '');

		if (obj_x.value.length == 0) {
			obj_x.value = 0;
		}

		if (obj_y.value.length == 0) {
			obj_y.value = 0;
		}

		if (obj_width.value.length == 0) {
			obj_width.value = crop_originalImageWidth;
		}

		if (obj_height.value.length == 0) {
			obj_height.value = crop_originalImageHeight;
		}

		if (obj_x.value > (crop_originalImageWidth - crop_minimumWidthHeight)) {
			obj_x.value = crop_originalImageWidth - crop_minimumWidthHeight;
		}

		if (obj_y.value > (crop_originalImageHeight - crop_minimumWidthHeight)) {
			obj_y.value = crop_originalImageHeight - crop_minimumWidthHeight;
		}

		if (obj_width.value / 1 > crop_originalImageWidth) {
			obj_width.value = crop_originalImageWidth - obj_x.value / 1;
		}

		if (obj_height.value / 1 > crop_originalImageHeight) {
			obj_height.value = crop_originalImageHeight - obj_y.value / 1;
		}

		if (obj_x.value / 1 + obj_width.value / 1 > crop_originalImageWidth) {
			obj_width.value = crop_originalImageWidth - obj_x.value;
		}

		if (obj_y.value / 1 + obj_height.value / 1 > crop_originalImageHeight) {
			obj_height.value = crop_originalImageHeight - obj_y.value;
		}

		cropDiv_dotted.style.left = Math.round(obj_x.value / 1 * (crop_imageWidth / crop_originalImageWidth)) + 'px';
		cropDiv_dotted.style.top = Math.round(obj_y.value / 1 * (crop_imageHeight / crop_originalImageHeight)) + 'px';
		cropDiv_dotted.style.width = Math.round((obj_width.value / 1 - (cropToolBorderWidth * 2)) * (crop_imageWidth / crop_originalImageWidth)) + 'px';
		cropDiv_dotted.style.height = Math.round((obj_height.value / 1 - (cropToolBorderWidth * 2)) * (crop_imageHeight / crop_originalImageHeight)) + 'px';

		repositionSmallSquares();
		resizeTransparentSquares();
	}

	function cropScript_setBasicEvents() {
		document.documentElement.ondragstart = crop_cancelEvent;
		document.documentElement.onselectstart = crop_cancelEvent;
		document.documentElement.onmousemove = cropScript_mouseMove;
		document.documentElement.onmouseup = cropScript_stopResizeMove;
		document.getElementById('input_crop_x').onblur = cropScript_setCropSizeByInput;
		document.getElementById('input_crop_y').onblur = cropScript_setCropSizeByInput;
		document.getElementById('input_crop_width').onblur = cropScript_setCropSizeByInput;
		document.getElementById('input_crop_height').onblur = cropScript_setCropSizeByInput;
	}

	function cropScript_validatePercent() {
		this.value = this.value.replace(/[^0-9]/gi, '');

		if (this.value.length == 0) {
			this.value = '1';
		}

		if (this.value / 1 > crop_maximumPercent) {
			this.value = '100';
		}

		if (this.value / 1 < crop_minimumPercent) {
			this.value = crop_minimumPercent;
		}
	}

	function crop_initFixedRatio() {
		if (crop_script_fixedRatio > 1) {
			document.getElementById('input_crop_height').value = Math.round(document.getElementById('input_crop_width').value) / crop_script_fixedRatio;
		} else {
			document.getElementById('input_crop_width').value = Math.round(document.getElementById('input_crop_height').value) / crop_script_fixedRatio;
		}

		cropScript_setCropSizeByInput();
	}

	function init_imageCrop() {
		cropScript_setBasicEvents();
		crop_createDivElements();
		cropScript_updateFormValues();

		if (crop_script_fixedRatio && crop_script_alwaysPreserveAspectRatio) {
			crop_initFixedRatio();
		}
	}

	return init_imageCrop;

});