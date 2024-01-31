(function() {
	var Drawer = function(element) {
		this.element = element;
		this.content = document.getElementsByClassName('js-drawer__body')[0];
		this.triggers = document.querySelectorAll('[aria-controls="'+this.element.getAttribute('id')+'"]');
		this.firstFocusable = null;
		this.lastFocusable = null;
		this.selectedTrigger = null;
		this.isModal = this.element.classList.contains('js-drawer--modal');
		this.showClass = "drawer--is-visible";
		this.preventScrollEl = this.getPreventScrollEl();
		this.initDrawer();
	};

	Drawer.prototype.getPreventScrollEl = function() {
		var scrollEl = false;
		var querySelector = this.element.getAttribute('data-drawer-prevent-scroll');
		if(querySelector) scrollEl = document.querySelector(querySelector);
		return scrollEl;
	};

	Drawer.prototype.initDrawer = function() {
		var self = this;
		if ( this.triggers ) {
			for(var i = 0; i < this.triggers.length; i++) {
				this.triggers[i].addEventListener('click', function(event) {
					event.preventDefault();
					if(self.element.classList.contains(self.showClass)) {
						self.closeDrawer(event.target);
						return;
					}
					self.selectedTrigger = event.target;
					self.showDrawer();
					self.initDrawerEvents();
				});
			}
		}

		if(this.element.classList.contains(this.showClass)) this.initDrawerEvents();
	};

    Drawer.prototype.showDrawer = function () {
		var self = this;
		this.content.scrollTop = 0;
		this.element.classList.add(this.showClass);
		this.getFocusableElements();
		moveFocus(this.element);
		this.element.addEventListener("transitionend", function cb(event) {
			moveFocus(self.element);
			self.element.removeEventListener("transitionend", cb);
		});
		this.emitDrawerEvents('drawerIsOpen', this.selectedTrigger);
		if(this.preventScrollEl) this.preventScrollEl.style.overflow = 'hidden';
	};

    Drawer.prototype.closeDrawer = function (target) {
		this.element.classList.remove(this.showClass);
		this.firstFocusable = null;
		this.lastFocusable = null;
		if(this.selectedTrigger) this.selectedTrigger.focus();
		this.cancelDrawerEvents();
		this.emitDrawerEvents('drawerIsClose', target);
		if(this.preventScrollEl) this.preventScrollEl.style.overflow = '';
	};

	Drawer.prototype.initDrawerEvents = function() {
		this.element.addEventListener('keydown', this);
		this.element.addEventListener('click', this);
	};

	Drawer.prototype.cancelDrawerEvents = function() {
		this.element.removeEventListener('keydown', this);
		this.element.removeEventListener('click', this);
	};

	Drawer.prototype.handleEvent = function (event) {
		switch(event.type) {
			case 'click': {
				this.initClick(event);
			}
			case 'keydown': {
				this.initKeyDown(event);
			}
		}
	};

	Drawer.prototype.initKeyDown = function(event) {
		if( event.keyCode && event.keyCode == 27 || event.key && event.key == 'Escape' ) {
			this.closeDrawer(false);
		} else if( this.isModal && (event.keyCode && event.keyCode == 9 || event.key && event.key == 'Tab' )) {
			this.trapFocus(event);
		}
	};

	Drawer.prototype.initClick = function(event) {
		if( !event.target.closest('.js-drawer__close') && !event.target.classList.contains('js-drawer') ) return;
		event.preventDefault();
		this.closeDrawer(event.target);
	};

	Drawer.prototype.trapFocus = function(event) {
		if( this.firstFocusable == document.activeElement && event.shiftKey) {
			event.preventDefault();
			this.lastFocusable.focus();
		}
		if( this.lastFocusable == document.activeElement && !event.shiftKey) {
			event.preventDefault();
			this.firstFocusable.focus();
		}
	}

	Drawer.prototype.getFocusableElements = function() {
		var allFocusable = this.element.querySelectorAll('[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), iframe, object, embed, [tabindex]:not([tabindex="-1"]), [contenteditable], audio[controls], video[controls], summary');
		this.getFirstVisible(allFocusable);
		this.getLastVisible(allFocusable);
	};

	Drawer.prototype.getFirstVisible = function(elements) {
		for(var i = 0; i < elements.length; i++) {
			if( elements[i].offsetWidth || elements[i].offsetHeight || elements[i].getClientRects().length ) {
				this.firstFocusable = elements[i];
				return true;
			}
		}
	};

	Drawer.prototype.getLastVisible = function(elements) {
		for(var i = elements.length - 1; i >= 0; i--) {
			if( elements[i].offsetWidth || elements[i].offsetHeight || elements[i].getClientRects().length ) {
				this.lastFocusable = elements[i];
				return true;
			}
		}
	};

	Drawer.prototype.emitDrawerEvents = function(eventName, target) {
		var event = new CustomEvent(eventName, {detail: target});
		this.element.dispatchEvent(event);
	};

	function moveFocus(element) {
    element.focus();
    if (document.activeElement !== element) {
      element.setAttribute('tabindex','-1');
      element.focus();
    }
  };

	window.Drawer = Drawer;

	var drawer = document.getElementsByClassName('js-drawer');
	if( drawer.length > 0 ) {
		for( var i = 0; i < drawer.length; i++) {
			(function(i){new Drawer(drawer[i]);})(i);
		}
	}
}());
