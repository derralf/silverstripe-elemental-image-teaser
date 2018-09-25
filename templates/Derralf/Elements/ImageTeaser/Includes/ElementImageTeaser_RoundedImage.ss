
    <div class="{$ColCss}">
        <div class="card {$Style}" data-mh="card-teaser-{$TeaserHolderID}">
            <% if $Image && $ShowImage %>
                <% if $ReadMoreLink.LinkURL %><a href="$ReadMoreLink.LinkURL" title="$ReadMoreLinkTitle.ATT" {$ReadMoreLink.TargetAttr} ><% end_if %>
                <img class="card-img-top img-circle img-responsive centered" src="$Image.FocusFillMax(260,260).Link" alt="$Image.Title.ATT">
                <% if $ReadMoreLink.LinkURL %></a><% end_if %>
            <% end_if %>

            <div class="card-block">
                <% if $ShowTitle && $Title %>
                    <{$TitleTagVariant} class="card-title">
                    <% if $ReadMoreLink.LinkURL %><a href="$ReadMoreLink.LinkURL" {$ReadMoreLink.TargetAttr}><% end_if %>
                    $Title
                    <% if $ReadMoreLink.LinkURL %></a><% end_if %>
                </{$TitleTagVariant}>
                <% end_if %>

                <% if $Content %>
                    <div class="card-text">
                        $Content
                    </div>
                <% end_if %>

                <% if $ReadMoreLink.LinkURL %>
                    <div class="element__readmorelink"><p><a href="$ReadMoreLink.LinkURL" class="{$ReadmoreLinkClass}" {$ReadMoreLink.TargetAttr} ><% if $ReadMoreLink.Title %>$ReadMoreLink.Title<% else %> mehr<% end_if %></a></p></div>
                <% end_if %>
            </div>
        </div>
    </div>