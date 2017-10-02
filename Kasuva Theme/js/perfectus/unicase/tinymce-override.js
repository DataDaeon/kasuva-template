if(window.tinyMceWysiwygSetup)
{
    tinyMceWysiwygSetup.prototype.originalGetSettings = tinyMceWysiwygSetup.prototype.getSettings;
    tinyMceWysiwygSetup.prototype.getSettings = function(mode)
    {

    var settings = this.originalGetSettings(mode);
    //add any extra settings you'd like below

    //makes "placeholder" a valid element for inputs
    settings.extended_valid_elements = '+div[*],+a[*],+span[*],+i[*]';
    //settings.valid_children = 'a[h1|h2|h3|h4|h5|h6|p|span|div|img]';
    //settings.force_br_newlines = true;
    //settings.force_p_newlines = false;
    settings.forced_root_block = false;
    return settings;

    }
}