<!-- <div class="testing">
</div> -->
<!DOCTYPE html>
<html>
<head>
	<script src="https://code.jquery.com/jquery-3.1.1.min.js" type="text/javascript"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">  
	<style>
	.multiple-image-picker-wrapper {
	    display: inline-block;
	}
	.multiple-image-picker-wrapper > .multiple-image-picker-file-data {
	    /* width: 10px; */
	    overflow: hidden;
	    /* height: 22px; */
	    /* position: relative; */
	    height: 0px;
	    width: 100%;
	}
	.multiple-image-picker-wrapper > .multiple-image-picker-file-data > .mip-data-files {
        position: absolute;
        display: none;
	}
	.multiple-image-picker {
	    display: inline-block;
	    padding: 0px;
	    margin: 0px;
	    position: relative;
	}

	.multiple-image-picker:hover .mip-prev-container > .mip-prev-action.mip-available,
	.multiple-image-picker:hover .mip-next-container > .mip-next-action.mip-available {
	    display: inherit;
	}

	.multiple-image-picker > .mip-container {
	    /*
	  * the container must posses the css flex not the child elements
	  */
	    align-content: flex-start;
	    justify-content: flex-start;
	    flex-direction: column;
	    display: inline-flex;
	    flex-wrap: wrap;
	    /* End of flex rule */
	    vertical-align: top;
	    width: 100%;
	    height: 100%;
	    background-color: orange;
	    // display: inherit;
	    padding: inherit;
	    margin: inherit;
	    overflow: hidden;
	}

	.multiple-image-picker > .mip-container > .mip-items {
	    /*display: inherit;*/
	    /*width:calc(100% - 10px);
	    height:calc(100% - 10px);*/
	    width: 100px;
	    height: 100px;
	    background-color: black;
	    margin-top: 5px;
	    margin-left: 5px;
	    color: white;
	    position: relative;
	    /*overflow: hidden;*/

	    
	}
	.multiple-image-picker > .mip-container > .mip-items:nth-last-child(1) {
	    padding-right:5px;
	    background-color: rgba(0,0,0,0);
	}
	.multiple-image-picker > .mip-container > .mip-items > img {
	    /*flex-shrink: 0;
	    min-width: 100%;
	    min-height: 100%*/
	}
	.multiple-image-picker > .mip-container > .mip-items > .mip-image-overlay-container > .mip-image-overlay-display {
        position: absolute;
	    background-color: rgba(0,0,0,0.5);
	    width: 100%;
	    height: 100%;
	    z-index: 1;
	}
	.multiple-image-picker > .mip-container > .mip-items > .mip-image-overlay-container > .mip-image-overlay-display > .mip-image-overlay-display-tbl {
	    display: table;
	    width: 100%;
	    height: 100%;
	}
	.multiple-image-picker > .mip-container > .mip-items > .mip-image-overlay-container > .mip-image-overlay-display > .mip-image-overlay-display-tbl > .mip-image-overlay-display-tbl-cell {
		display: table-cell;
		vertical-align: middle;
		width: 100%;
		height: 100%;
		position: relative;
		text-align: center;
	}
	.multiple-image-picker > .mip-container > .mip-items > .mip-image {
	    display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        width: 100%;
        height: 100%;
        position: relative;
	}
	.multiple-image-picker > .mip-container > .mip-items > .mip-image-caption,
	.multiple-image-picker > .mip-container > .mip-items > .mip-image-data
	{
        height: 0px;
		width: 100%;
	}
	.multiple-image-picker > .mip-container > .mip-items > .mip-image-caption > label {
		white-space: nowrap;
        background: rgba(0, 0, 0, 0);
        position: absolute;
        z-index: 1;
        /* border-radius: 100%; */
        /* box-shadow: 0px 0px 100px rgba(0,0,0,0.2) inset, 0px 0px 10px rgba(0,0,0,1); */
        text-shadow: 0px 0px 10px black;
        color: white;
        width: 100%;
        text-overflow: ellipsis;
        overflow: hidden;
	}

	.multiple-image-picker > .mip-prev-container > .mip-prev-action,
	.multiple-image-picker > .mip-next-container > .mip-next-action {
	    width: 50px;
	}

	.multiple-image-picker > .mip-prev-container,
	.multiple-image-picker > .mip-next-container {
	    height: 100%;
	    display: inherit;
	    padding: inherit;
	    margin: inherit;
	    position: relative;
	}

	.multiple-image-picker > .mip-prev-container > .mip-prev-action,
	.multiple-image-picker > .mip-next-container > .mip-next-action {
	    height: inherit;
	    background-color: rgba(255, 255, 0, 0.5);
	    display: none;
	    padding: inherit;
	    margin: inherit;
	    outline: solid 1px white;
	    position: absolute;
	}

	.multiple-image-picker > .mip-prev-container > .mip-prev-action {
	    left: -50px;
	}

	.multiple-image-picker > .mip-next-container > .mip-next-action {
	    right: -50px;
	}
	</style>
</head>
<body>
	<!-- <div class="testing"></div> -->
	<input class="testing" name="testing" type="text" />
	<!-- <input class="testingz" name="testing" type="text" /> -->
</body>
</html>
<script>
	(function($) {
		$.fn.multipleImagePicker = function(options) {
			var settings = $.extend({}, $.fn.multipleImagePicker.defaults, options);
			console.log(this)
			return this.each(function(index, element) {
				var _this = $(this);
				_this = systemRootPlugin.setupComponents(_this);
				systemRootPlugin.applySettings.call(_this, settings);
				systemRootPlugin.castEvents.call(_this, settings);
			});
		}
		$.fn.multipleImagePicker.defaults = {
			'fieldName': 'testing',
			'enableInputFileSaving':false,
			'containerResize': true,
			'containerResizeSettings': {
				grid: 105
			},
			'containerSize': 110,
			'thumbNailSize': 100
		};
		function appendImages2(file, inputFile) {
			var _thisData = this;
			var defer = {};
			// var _thisInputFile = this;
			defer.readFileProgress = 0;
			defer.ajaxProgress = 0;
			defer.getProgress = function(){
				if(defer.executeAjaxWith){
					return parseInt( ( defer.readFileProgress + defer.ajaxProgress ) / 2 );	
				}else{
					return parseInt( ( defer.readFileProgress + defer.ajaxProgress ) );
				}
			}
			defer.getProgressMessage = function(){
				var temp = this.getProgress();
				if( temp >= 100 ){
					return 'Rendering image please wait...';
				}else{
					return temp+'%';
				}
			}
			defer.then = function(cb){
				this.realCB = cb;
			}
			defer.imageOnload = function(cb){
				this.imageOnloadCB = cb;
				return this;
			}
			defer.setAjax = function(cb){
				defer.executeAjaxWith = function (imageParts) {
					var settings = cb;
					if($.type(settings) != "object"){
						delete defer.executeAjaxWith;
						return false;
					}
					var defaultSettings = {
						type: 'POST',
						dataType : 'json',
						processData: false, // important
						contentType: false, // important
					}
					defer.ajaxSettings = $.extend(defaultSettings, settings);
					var tempSuccess = null;
					if(defer.ajaxSettings.success){
						var tempSuccess = defer.ajaxSettings.success;
					}
					defer.ajaxSettings.success = function(data){
						// imageParts.loadingProgressDisplay.text('Rendering image please wait...');
						if($.type(tempSuccess) == "function"){
							temp(data);
						}
					}
					
					var tempXhr = null;
					if(defer.ajaxSettings.xhr){
						tempXhr = defer.ajaxSettings.xhr;
					}
					defer.ajaxSettings.xhr = function() {
			            var xhr = new window.XMLHttpRequest();
				        var xhrObject = xhr;
				        (xhrObject.upload||xhrObject).addEventListener('progress', function(e) {
					        var done = e.position || e.loaded
					        var total = e.totalSize || e.total;
					        defer.ajaxProgress = Math.round(done/total*100);
					        imageParts.loadingProgressDisplay.text(defer.getProgressMessage());
					    });
					    if($.type(tempXhr) == "function"){
					    	tempXhr();
					    }
						return xhr;
			        }
			        $.ajax(defer.ajaxSettings);
				};
			}
			setTimeout(function() {
				var iicParts = _thisData.templateParts.imageItemContainer2(_thisData.templateParts.containerImages);

				iicParts.container.css({
					width:_thisData.options.thumbNailSize+'px',
					height:_thisData.options.thumbNailSize+'px',
				})

				_thisData.imageDomModel.push({
					parts: iicParts,
					dataIndex: _thisData.imageDataModel.push({ 
						file:file
					}) - 1
				});
				// var canvas = $('<canvas style="width:100%;height:100%;"></canvas>').get(0);
				// var canvasContext = canvas.getContext('2d');
				// console.log("THEA:SDKL", file)
				// var urlImage = URL.createObjectURL(file); //SUSI SA LAHAT version 1
				var reader = new window.FileReader();
				reader.readAsDataURL(file); //SUSI SA LAHAT
				var imgElement = new Image();

			    $(imgElement).css({
			    	width:'100%',
			    	// height:'100%',
			    	position:'absolute'
			    });
			    // console.log("WATCH me", file)
			    iicParts.imageLabel.text(file.name);
			    iicParts.imageAppendContainer.append(imgElement);

				imgElement.onload = function() {
					if($(imgElement).parent().height() > $(imgElement).height()){
						$(imgElement).css({
							width: '',
							height: '100%'
						});
					}
					iicParts.loadingProgressOverlay.hide();
					if($.type(defer.imageOnloadCB) == "function"){
						defer.imageOnloadCB(iicParts);
					}
				};
				reader.onprogress = function(data) {
		            if (data.lengthComputable) {                                            
		                var progress = parseInt( ((data.loaded / data.total) * 100), 10 );
		                defer.readFileProgress = progress;
		                iicParts.loadingProgressDisplay.text(defer.getProgressMessage());
		            }
		        }
				reader.onloadend = function(eReader) {
					imgElement.src = eReader.target.result;
				}
				if(defer.executeAjaxWith){
					defer.executeAjaxWith(iicParts);
				}
				if($.type(defer.realCB) == "function"){
					defer.realCB(iic);
				}
			}, 0);
			return defer;
		}

		var systemRootPlugin = {};

		systemRootPlugin.applySettings = function(settings) {
			if (settings.containerResize) {
				this.resizable(settings.containerResizeSettings);
			}
			if (settings.containerSize) {
				this.css({
					width: settings.containerSize,
					height: settings.containerSize
				});
			}

			this.data('multipleImagePicker').options = settings;

			return this;
		};

		systemRootPlugin.setupComponents = function(element) {
			var templateParts = this.template(element);
			element.wrap(templateParts.wrapper);

			if (element.is('input[type="text"]')) {
				element.after(templateParts.multipleImagePickerContainer);
				element.hide();
				templateParts.multipleImageInputDataValue = element;
				element = templateParts.multipleImagePickerContainer;
			} else {
				element.before(templateParts.multipleImageInputDataValue);
				templateParts.multipleImageInputDataValue.hide();
				element.addClass('multiple-image-picker');
			}
			templateParts.multipleImageInputDataValue.after(templateParts.multipleImagePickerFiles);
			templateParts.multipleImageInputDataValue.data('value', []);
			templateParts.multipleImageInputDataValue.data('domValue',[]);

			element.html(
				templateParts.anchorPrevious
				.add(templateParts.containerImages)
				.add(templateParts.anchorNext)
			);
			element.after(templateParts.controlActions);

			element.data('multipleImagePicker', {});
			element.data('multipleImagePicker').imageDataModel = [];
			element.data('multipleImagePicker').imageDomModel = [];
			element.data('multipleImagePicker').templateParts = templateParts;

			return element;
		};

		systemRootPlugin.template = function(ele) {
			console.log(ele)
			var parts = {
				anchorPrevious: $('<div class="mip-prev-container"><div class="mip-prev-action mip-available"></div></div>').clone(),
				containerImages: $('<div class="mip-container"></div>').clone(),
				imageItemContainer: function() {
					return $('<div class="mip-items"><div class="mip-image-overlay-container"><div class="mip-image-overlay-display"><div class="mip-image-overlay-display-tbl"><div class="mip-image-overlay-display-tbl-cell">0%</div></div></div></div><div class="mip-image-caption"><label><input type="checkbox" /><span></span></label></div><div class="mip-image"></div></div>').clone();
				},
				imageItemContainer2: function(appendTarget) {
					var temp = $(
					'<div class="mip-items">'+
						'<div class="mip-image-overlay-container">'+
							'<div class="mip-image-overlay-display">'+
								'<div class="mip-image-overlay-display-tbl">'+
									'<div class="mip-image-overlay-display-tbl-cell">0%</div>'+
								'</div>'+
							'</div>'+
						'</div>'+
						'<div class="mip-image-caption">'+
							'<label>'+
								'<input class="mip-checkbox-action" type="checkbox" />'+
								'<span class="mip-image-text"></span>'+
							'</label>'+
						'</div>'+
						'<div class="mip-image"></div>'+
					'</div>'
					).clone();
					appendTarget.append(temp);
					var targetParts = {};
					targetParts.container = temp;
					targetParts.loadingProgressOverlay = temp.children('.mip-image-overlay-container').children('.mip-image-overlay-display');
					targetParts.loadingProgressDisplay = targetParts.loadingProgressOverlay.children('.mip-image-overlay-display-tbl').children('.mip-image-overlay-display-tbl-cell');
					targetParts.imageCheckboxAction = temp.children('.mip-image-caption').children('label').children('.mip-checkbox-action');
					targetParts.imageLabel = temp.children('.mip-image-caption').children('label').children('span.mip-image-text');
					targetParts.imageAppendContainer = temp.children('.mip-image');
					return targetParts;
				},
				anchorNext: $('<div class="mip-next-container"><div class="mip-next-action mip-available"></div></div>').clone(),
				controlActions: $('<div style="text-align:center;"><span class="mip-check-all-image">Check all</span><span class="mip-add-image">Add</span><span class="mip-remove-image">Remove</span></div>').clone(),
				wrapper: '<div class="multiple-image-picker-wrapper"/>',
				multipleImagePickerContainer: $('<div class="multiple-image-picker"></div>').clone(),
				multipleImagePickerFiles:$('<div class="multiple-image-picker-file-data"><div class="mip-data-files"></div><div class="mip-input-file-element"></div></div>').clone(),
				multipleImageInputDataValue: $('<input name="tempName" type="text">').clone(),
				multipleImageInputPicker: function() {
					return $('<input type="file" multiple>').clone();
				}
			}
			return parts;
		};
		
		systemRootPlugin.castEvents = function(settings) {
			var _thisData = this.data('multipleImagePicker');
			_thisData
				.templateParts.anchorPrevious
				.children('.mip-prev-action')
				.on('mousedown.multipleImagePicker', function() {
					_thisData.templateParts.containerImages.scrollLeft(_thisData.templateParts.containerImages.scrollLeft()-_thisData.options.containerResizeSettings.grid);
				});

			_thisData
				.templateParts.anchorNext
				.children('.mip-next-action')
				.on('mousedown.multipleImagePicker mouseup.multipleImagePicker mouseleave.multipleImagePicker', function(e) {
					var clear = (e.type == 'mouseup' || e.type == 'mouseleave' || $(this).is(':data("scroll")') );
					if(clear){
						clearInterval($(this).data('scroll'));
						$(this).removeData('scroll');
					}
					if(e.type == 'mousedown'){
						_thisData.templateParts.containerImages.scrollLeft(_thisData.templateParts.containerImages.scrollLeft()+_thisData.options.containerResizeSettings.grid);
						$(this).data('scroll',setInterval(function(){
							_thisData.templateParts.containerImages.scrollLeft(_thisData.templateParts.containerImages.scrollLeft()+_thisData.options.containerResizeSettings.grid);
						}, 1000));
					}
				});

			_thisData
				.templateParts.controlActions
				.children('.mip-check-all-image')
				.on('click.multipleImagePicker', function() {
					_thisData.imageDomModel.forEach(function(val){
						val.parts.imageCheckboxAction.prop('checked', true);
					});
				});

			_thisData
				.templateParts.controlActions
				.children('.mip-add-image')
				.on('click.multipleImagePicker', function() {
					var multipleImageInputDataValue = _thisData.templateParts.multipleImageInputDataValue;
					var inputFileElement = _thisData.templateParts.multipleImageInputPicker().get(0);
					inputFileElement.name = settings.fieldName+'[]';
					inputFileElement.accept = "image/*";
					// var jqx = $(x)
					if(settings.enableInputFileSaving){
						_thisData.templateParts.multipleImagePickerFiles.children('.mip-input-file-element').append(inputFileElement);
					}
					// jqx.attr('name','[]');
					inputFileElement.onchange = function() {
						var myFormData = new FormData($('<form></form>').get(0));
						myFormData.append('action', 'add');
						var totalSize = 0;
						for (var fileIndex = 0; fileIndex < inputFileElement.files.length; fileIndex++) {
							totalSize = totalSize + inputFileElement.files[fileIndex].size;
							myFormData.delete('pictureFile');
							myFormData.append('pictureFile', inputFileElement.files[fileIndex]);
							appendImages2.call(_thisData, inputFileElement.files[fileIndex], inputFileElement)
							// .setAjax({
							// 	url: '/debugger2/test',
							// 	data: myFormData
							// });
						}
					}
					inputFileElement.value = null;
					inputFileElement.focus();
					inputFileElement.click();
					inputFileElement.blur();
				});

			_thisData
				.templateParts.controlActions
				.children('.mip-remove-image')
				.on('click.multipleImagePicker', function() {
					var deleted = 0;
					_thisData.imageDomModel.forEach(function(data,index,arr){
						if(data.parts.imageCheckboxAction.is(':checked')){
							data.parts.container.remove();
							delete _thisData.imageDataModel[data.dataIndex];
							delete arr[index];
							deleted++;
						}else{
							arr[index].dataIndex = arr[index].dataIndex - deleted;
						}
					});
					_thisData.imageDomModel = _thisData.imageDomModel.filter(Boolean);
					_thisData.imageDataModel = _thisData.imageDataModel.filter(Boolean);
				});
		};
		
	}(jQuery));

	$(document).ready(function() {
		$('.testing').multipleImagePicker();
		console.log($('.testing').next().data());
	});

</script>