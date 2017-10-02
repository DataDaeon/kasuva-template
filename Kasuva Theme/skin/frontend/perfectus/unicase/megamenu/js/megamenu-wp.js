var puMenuLoaded = false;
var puMobileMenuLoaded = false;

function puInitPopupContent()
{
    if (puMenuLoaded) return;
    var xMenu = $('pumegamenu');
    if (typeof puPopupMenuContent != 'undefined') xMenu.innerHTML = puPopupMenuContent + xMenu.innerHTML;
    puMenuLoaded = true;
}

function puInitMobileMenuContent()
{
    if (puMobileMenuLoaded) return;
    var xMenu = $('menu-content');
    if (typeof puMobileMenuContent != 'undefined') xMenu.innerHTML = puMobileMenuContent;
    puMobileMenuLoaded = true;
}

function puShowMenuPopup(objMenu, event, popupId)
{
    puInitPopupContent();
    if (typeof puMegamenuTimerHide[popupId] != 'undefined') clearTimeout(puMegamenuTimerHide[popupId]);
    objMenu = $(objMenu.id); var popup = $(popupId); if (!popup) return;
    if (!!puActiveMenu) {
        puHideMenuPopup(objMenu, event, puActiveMenu.popupId, puActiveMenu.menuId);
    }
    puActiveMenu = {menuId: objMenu.id, popupId: popupId};
    if (!objMenu.hasClassName('active')) {
        puMegamenuTimerShow[popupId] = setTimeout(function() {
            objMenu.addClassName('active');
            var popupWidth = CUSTOMMENU_POPUP_WIDTH;
            if (!popupWidth) popupWidth = popup.getWidth();
            var pos = puPopupPos(objMenu, popupWidth);
            popup.style.top = pos.top + 'px';
            popup.style.left = pos.left + 'px';
            puSetPopupZIndex(popup);
            if (CUSTOMMENU_POPUP_WIDTH)
                popup.style.width = CUSTOMMENU_POPUP_WIDTH + 'px';
            // --- Static Block width ---
            var block2 = $(popupId).select('div.block2');
            if (typeof block2[0] != 'undefined') {
                var wStart = block2[0].id.indexOf('_w');
                if (wStart > -1) {
                    var w = block2[0].id.substr(wStart+2);
                } else {
                    var w = 0;
                    $(popupId).select('div.block1 div.column').each(function(item) {
                        w += $(item).getWidth();
                    });
                }
                if (w) block2[0].style.width = w + 'px';
            }
            // --- change href ---
            var puMenuAnchor = $(objMenu.select('a')[0]);
            puChangeTopMenuHref(puMenuAnchor, true);
            // --- show popup ---
            if (typeof jQuery == 'undefined') {
                popup.style.display = 'block';
            } else {
                jQuery('#' + popupId).stop(true, true).fadeIn();
            }
        }, CUSTOMMENU_POPUP_DELAY_BEFORE_DISPLAYING);
    }
}

function puHideMenuPopup(element, event, popupId, menuId)
{
    if (typeof puMegamenuTimerShow[popupId] != 'undefined') clearTimeout(puMegamenuTimerShow[popupId]);
    var element = $(element); var objMenu = $(menuId) ;var popup = $(popupId); if (!popup) return;
    var puCurrentMouseTarget = getCurrentMouseTarget(event);
    if (!!puCurrentMouseTarget) {
        if (!puIsChildOf(element, puCurrentMouseTarget) && element != puCurrentMouseTarget) {
            if (!puIsChildOf(popup, puCurrentMouseTarget) && popup != puCurrentMouseTarget) {
                if (objMenu.hasClassName('active')) {
                    puMegamenuTimerHide[popupId] = setTimeout(function() {
                        objMenu.removeClassName('active');
                        // --- change href ---
                        var puMenuAnchor = $(objMenu.select('a')[0]);
                        puChangeTopMenuHref(puMenuAnchor, false);
                        // --- hide popup ---
                        if (typeof jQuery == 'undefined') {
                            popup.style.display = 'none';
                        } else {
                            jQuery('#' + popupId).stop(true, true).fadeOut();
                        }
                    }, CUSTOMMENU_POPUP_DELAY_BEFORE_HIDING);
                }
            }
        }
    }
}

function puPopupOver(element, event, popupId, menuId)
{
    if (typeof puMegamenuTimerHide[popupId] != 'undefined') clearTimeout(puMegamenuTimerHide[popupId]);
}

function puPopupPos(objMenu, w)
{
    var pos = objMenu.cumulativeOffset();
    var wraper = $('custommenu');
    var posWraper = wraper.cumulativeOffset();
    var xTop = pos.top - posWraper.top
    if (CUSTOMMENU_POPUP_TOP_OFFSET) {
        xTop += CUSTOMMENU_POPUP_TOP_OFFSET;
    } else {
        xTop += objMenu.getHeight();
    }
    var res = {'top': xTop};
    if (CUSTOMMENU_RTL_MODE) {
        var xLeft = pos.left - posWraper.left - w + objMenu.getWidth();
        if (xLeft < 0) xLeft = 0;
        res.left = xLeft;
    } else {
        var wWraper = wraper.getWidth();
        var xLeft = pos.left - posWraper.left;
        if ((xLeft + w) > wWraper) xLeft = wWraper - w;
        if (xLeft < 0) xLeft = 0;
        res.left = xLeft;
    }
    return res;
}

function puChangeTopMenuHref(puMenuAnchor, state)
{
    if (state) {
        puMenuAnchor.href = puMenuAnchor.rel;
    } else {
        puMenuAnchor.href = 'javascript:void(0);';
    }
}

function puIsChildOf(parent, child)
{
    if (child != null) {
        while (child.parentNode) {
            if ((child = child.parentNode) == parent) {
                return true;
            }
        }
    }
    return false;
}

function puSetPopupZIndex(popup)
{
    $$('.pu-custom-menu-popup').each(function(item){
       item.style.zIndex = '9999';
    });
    popup.style.zIndex = '10000';
}

function getCurrentMouseTarget(xEvent)
{
    var puCurrentMouseTarget = null;
    if (xEvent.toElement) {
        puCurrentMouseTarget = xEvent.toElement;
    } else if (xEvent.relatedTarget) {
        puCurrentMouseTarget = xEvent.relatedTarget;
    }
    return puCurrentMouseTarget;
}

function getCurrentMouseTargetMobile(xEvent)
{
    if (!xEvent) var xEvent = window.event;
    var puCurrentMouseTarget = null;
    if (xEvent.target) puCurrentMouseTarget = xEvent.target;
        else if (xEvent.srcElement) puCurrentMouseTarget = xEvent.srcElement;
    if (puCurrentMouseTarget.nodeType == 3) // defeat Safari bug
        puCurrentMouseTarget = puCurrentMouseTarget.parentNode;
    return puCurrentMouseTarget;
}

/* Mobile */
function puMenuButtonToggle()
{
    $('menu-content').toggle();
}

function puGetMobileSubMenuLevel(id)
{
    var rel = $(id).readAttribute('rel');
    return parseInt(rel.replace('level', ''));
}

function puSubMenuToggle(obj, activeMenuId, activeSubMenuId)
{
    var currLevel = puGetMobileSubMenuLevel(activeSubMenuId);
    // --- hide submenus ---
    $$('.pu-custom-menu-submenu').each(function(item) {
        if (item.id == activeSubMenuId) return;
        var xLevel = puGetMobileSubMenuLevel(item.id);
        if (xLevel >= currLevel) {
            $(item).hide();
        }
    });
    // --- reset button state ---
    $('custommenu-mobile').select('span.button').each(function(xItem) {
        var subMenuId = $(xItem).readAttribute('rel');
        if (!$(subMenuId).visible()) {
            $(xItem).removeClassName('open');
        }
    });
    // ---
    if ($(activeSubMenuId).getStyle('display') == 'none') {
        $(activeSubMenuId).show();
        $(obj).addClassName('open');
    } else {
        $(activeSubMenuId).hide();
        $(obj).removeClassName('open');
    }
}

function puResetMobileMenuState()
{
    if ($('menu-content') != undefined) $('menu-content').hide();
    $$('.pu-custom-menu-submenu').each(function(item) {
        $(item).hide();
    });
    if ($('custommenu-mobile') != undefined) {
        $('custommenu-mobile').select('span.button').each(function(item) {
            $(item).removeClassName('open');
        });
    }
}

function puCustomMenuMobileToggle()
{
    var w = window,
        d = document,
        e = d.documentElement,
        g = d.getElementsByTagName('body')[0],
        x = w.innerWidth || e.clientWidth || g.clientWidth,
        y = w.innerHeight|| e.clientHeight|| g.clientHeight;

    if (puMobileMenuEnabled && CUSTOMMENU_MOBILE_MENU_WIDTH_INIT > x) {

        puInitMobileMenuContent();
        if ($('pumegamenu') != undefined) $('pumegamenu').hide();
        if ($('pumegamenu-mobile') != undefined) $('pumegamenu-mobile').show();
        // --- ajax load ---
        if (puMoblieMenuAjaxUrl) {
            new Ajax.Request(
                puMoblieMenuAjaxUrl, {
                    asynchronous: true,
                    method: 'post',
                    onSuccess: function(transport) {
                        if (transport && transport.responseText) {
                            try {
                                response = eval('(' + transport.responseText + ')');
                            } catch (e) {
                                response = {};
                            }
                        }
                        puMobileMenuContent = response;
                        puMobileMenuLoaded = false;
                        puInitMobileMenuContent();
                    }
                }
            );
            puMoblieMenuAjaxUrl = null;
        }

    } else {

        if ($('pumegamenu-mobile') != undefined) $('pumegamenu-mobile').hide();
        puResetMobileMenuState();
        if ($('pumegamenu') != undefined) $('pumegamenu').show();
        // --- ajax load ---
        if (puMenuAjaxUrl) {
            new Ajax.Request(
                puMenuAjaxUrl, {
                    asynchronous: true,
                    method: 'post',
                    onSuccess: function(transport) {
                        if (transport && transport.responseText) {
                            try {
                                response = eval('(' + transport.responseText + ')');
                            } catch (e) {
                                response = {};
                            }
                        }
                        if ($('pumegamenu') != undefined) $('pumegamenu').update(response.topMenu);
                        puPopupMenuContent = response.popupMenu;
                    }
                }
            );
            puMenuAjaxUrl = null;
        }

    }

    if ($('pumegamenu-loading') != undefined) $('pumegamenu-loading').remove();
}
