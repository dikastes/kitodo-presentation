/**
 * (c) Kitodo. Key to digital objects e.V. <contact@kitodo.org>
 *
 * This file is part of the Kitodo and TYPO3 projects.
 *
 * @license GNU General Public License version 3 or later.
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

const className = 'score-visible';
const scrollOffset = 100;
/**
 * Encapsulates especially the score behavior
 * @constructor
 * @param {ol.Map} map
 */
const dlfViewerScoreControl = function(dlfViewer, pagebeginning, pagecount) {

  this.dlfViewer = dlfViewer;

/**
*@ type(number)
*/
this.pagecount = pagecount;

	/**
	 * @type {number}
	 * @private
	 */
	this.position = 0;

	/**
	 * @type {string}
	 * @private
	 */
	this.pagebeginning = pagebeginning;

    /**
     * @type {Object}
     * @private
     */
    this.dic = $('#tx-dlf-tools-score').length > 0 && $('#tx-dlf-tools-score').attr('data-dic') ?
        dlfUtils.parseDataDic($('#tx-dlf-tools-score')) :
        {
            'score':'Score',
            'score-loading':'Loading score...',
            'score-on':'Activate score',
            'score-off':'Deactivate score',
            'activate-score-initially':'0',
            'score-scroll-element':'html, body'};

    /**
     * @type {number}
     * @private
     */
    this.activateScoreInitially = this.dic['activate-score-initially'] === "1" ? 1 : 0;

    /**
     * @type {string}
     * @private
     */
    this.scoreScrollElement = this.dic['score-scroll-element'];

    $('#tx-dlf-score').text(this.dic['score-loading']);

    this.changeActiveBehaviour();
};

/**
 * @param {ScoreFeature} scoreData
 */
dlfViewerScoreControl.prototype.loadScoreData = function (scoreData) {
	const target = document.getElementById('tx-dlf-score');
  if (target !== null) {
		target.innerHTML = scoreData;
	}

  /*
  const image = new Image();

  const canvas = document.createElement("canvas");
  canvas.innerHTML = scoreData
  const clonedSvgElement = canvas.cloneNode(true);
  const outerHTML = clonedSvgElement.outerHTML;
  const blob = new Blob([outerHTML],{type:'image/svg+xml;charset=utf-8'});
  const URL = window.URL || window.webkitURL || window;
  const blobURL = URL.createObjectURL(blob);
  let png = canvas.toDataURL();
  image.src = blobURL;
  image.width = 1000;
  image.height = 1000;
  image.style.backgroundColor= "black";


  let context = canvas.getContext('2d');


  context.drawImage(image, 0, 0, 1500, 1000 );

  $(".fulltext-container").append(image);
  console.log("this is the image source" +blobURL)

  $("#tx_dlf_scoredownload").attr({
    "href": png,
    "download": "demo.png"
  });
  $("#tx_dlf_scoredownload").click();
*/
};

/**
 * Add active / deactive behavior in case of click on control depending if the full text should be activated initially.
 */
dlfViewerScoreControl.prototype.changeActiveBehaviour = function() {
    if (dlfUtils.getCookie("tx-dlf-pageview-score-select") === 'enabled' && this.pagecount == 1) {
        this.addActiveBehaviourForSwitchOn();
    } else  {
        this.addActiveBehaviourForSwitchOff();
        this.disableScoreSelect();
    }
};

dlfViewerScoreControl.prototype.addActiveBehaviourForSwitchOn = function() {
  console.log("addActiveBehaviourForSwitchOn")
    const anchorEl = $('#tx-dlf-tools-score');
    if (anchorEl.length > 0){
        const toggleScore = $.proxy(function(event) {
            event.preventDefault();

            this.activateScoreInitially = 0;

            if ($(event.target).hasClass('active')) {
                this.deactivate();
                return;
            }

            this.activate();
        }, this);

        anchorEl.on('click', toggleScore);
        anchorEl.on('touchstart', toggleScore);
    }

    // set initial title of score element
    $("#tx-dlf-tools-score")
        .text(this.dic['score'])
        .attr('title', this.dic['score']);

    this.activate();
};

dlfViewerScoreControl.prototype.addActiveBehaviourForSwitchOff = function() {
  console.log("addActiveBehaviourForSwitchOff")
    const anchorEl = $('#tx-dlf-tools-score');
    if (anchorEl.length > 0){
        const toggleScore = $.proxy(function(event) {
            event.preventDefault();

            if ($(event.target).hasClass('active')) {
                this.deactivate();
                return;
            }

            this.activate();
        }, this);

        anchorEl.on('click', toggleScore);
        anchorEl.on('touchstart', toggleScore);
    }

    // set initial title of score element
    $("#tx-dlf-tools-score")
        .text(this.dic['score-on'])
        .attr('title', this.dic['score-on']);

    // if score is activated via cookie than run activation method
    if (dlfUtils.getCookie("tx-dlf-pageview-score-select") === 'enabled') {
        // activate the score behavior
        this.activate();
    }
};

/**
 * Activate Score Features
 */
dlfViewerScoreControl.prototype.activate = function() {
  console.log("activate")
    const controlEl = $('#tx-dlf-tools-score');

    // now activate the score overlay and map behavior
    this.enableScoreSelect();
    dlfUtils.setCookie("tx-dlf-pageview-score-select", 'enabled');
    $(controlEl).addClass('active');

    // trigger event
    $(this).trigger("activate-fulltext", this);
};

/**
 * Activate Fulltext Features
 */
dlfViewerScoreControl.prototype.deactivate = function() {
  console.log("deactivate")
    const controlEl = $('#tx-dlf-tools-score');

    // deactivate fulltext
    this.disableScoreSelect();
    dlfUtils.setCookie("tx-dlf-pageview-score-select", 'disabled');
    $(controlEl).removeClass('active');

    // trigger event
    $(this).trigger("deactivate-fulltext", this);
};

/**
 * Disable Score Features
 *
 * @return void
 */
dlfViewerScoreControl.prototype.disableScoreSelect = function() {
  console.log("disable ScoreSelect  is selcted")

  $('#tx-dfgviewer-map').width('100%');
  this.dlfViewer.updateLayerSize();

    $("#tx-dlf-tools-score").removeClass(className)

    if(this.activateFullTextInitially === 0) {
        $("#tx-dlf-tools-score")
			.text(this.dic['score-on'])
			.attr('title', this.dic['score-on']);
    }

    $('#tx-dlf-score').removeClass(className);
    $('#tx-dlf-score').hide();
    $('body').removeClass(className);

};

/**
 * Activate Score Features
 */
dlfViewerScoreControl.prototype.enableScoreSelect = function() {
  console.log("enable score is selcted")

  $('#tx-dfgviewer-map').width('50%');
  this.dlfViewer.updateLayerSize();


    // show score container
    $("#tx-dlf-tools-score").addClass(className);

    if(this.activateFullTextInitially=== 0) {
        $("#tx-dlf-tools-score")
        .text(this.dic['score-off'])
        .attr('title', this.dic['score-off']);
    }

    $('#tx-dlf-score').addClass(className);
    $('#tx-dlf-score').show();
    $('body').addClass(className);
	this.scrollToPagebeginning();
};

/**
 * Scroll to Element with given ID
 */
dlfViewerScoreControl.prototype.scrollToPagebeginning = function() {
	// get current position of pb element
  if(this.pagebeginning){
    const currentPosition = $('#tx-dlf-score svg g#' + this.pagebeginning)?.parent()?.position()?.top ?? 0;
    // set target position if zero
    this.position = this.position == 0 ? currentPosition : this.position;
    // trigger scroll
    $('#tx-dlf-score').scrollTop(this.position - scrollOffset);
  }else{
        $('#tx-dlf-tools-score').hide();
  }
};
