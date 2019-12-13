
    <div class="{$ColCss} mb-4">
        <div class="card h-100 {$Style}" data-mh="card-teaser-{$TeaserHolderID}">

            <% if $Image && $ShowImage %>
                <% if $ReadMoreLink.LinkURL %><a href="$ReadMoreLink.LinkURL" title="$ReadMoreLinkTitle.ATT" {$ReadMoreLink.TargetAttr} ><% end_if %>
                <img width="720" height="405" class="card-img-top img-fluid" src="$Image.FocusFillMax(720,405).Link" alt="$Image.AltText.ATT">
                <% if $ReadMoreLink.LinkURL %></a><% end_if %>
            <% end_if %>

            <div class="XXXcard-block card-body">

                <% if $ShowTitle && $Title %>
                    <{$TitleTagVariant} class="card-title">
                    <% if $ReadMoreLink.LinkURL %><a href="$ReadMoreLink.LinkURL" {$ReadMoreLink.TargetAttr}><% end_if %>
                    $Title
                    <% if $ReadMoreLink.LinkURL %></a><% end_if %>
                    </{$TitleTagVariant}>
                <% end_if %>

                <% if $useSubtitle && $Subtitle %>
                    <h3 class="card-subtitle">$Subtitle</h3>
                <% end_if %>

                <% if $Content %>
                    <div class="card-text">
                        $Content
                    </div>
                <% end_if %>

                <% if $ReadMoreLink.LinkURL %>
                    <div class="element__readmorelink"><a href="$ReadMoreLink.LinkURL" class="{$ReadmoreLinkClass}" {$ReadMoreLink.TargetAttr} ><% if $ReadMoreLink.Title %>$ReadMoreLink.Title<% else %> mehr<% end_if %></a></div>
                <% end_if %>

                <%--<p><code>themes/mesch/templates/Derralf/Elements/ImageTeaser/Includes/ElementImageTeaser.ss</code></p>--%>
            </div>
        </div>
    </div>

    <%--<div class="{$ColCss}">--%>
        <%--<div class="card {$Style}" data-mh="card-teaser-{$TeaserHolderID}">--%>
            <%--<% if $Image && $ShowImage %>--%>
                <%--<% if $ReadMoreLink.LinkURL %><a href="$ReadMoreLink.LinkURL" title="$ReadMoreLinkTitle.ATT" {$ReadMoreLink.TargetAttr} ><% end_if %>--%>
                <%--<img width="720" height="405" class="card-img-top img-responsive forced" src="$Image.FocusFillMax(720,405).Link" alt="$Image.AltText.ATT">--%>
                <%--<% if $ReadMoreLink.LinkURL %></a><% end_if %>--%>
            <%--<% end_if %>--%>

        <%--<div class="card-block">--%>
            <%--<% if $ShowTitle && $Title %>--%>
                <%--<{$TitleTagVariant} class="card-title">--%>
                <%--<% if $ReadMoreLink.LinkURL %><a href="$ReadMoreLink.LinkURL" {$ReadMoreLink.TargetAttr}><% end_if %>--%>
                <%--$Title--%>
                <%--<% if $ReadMoreLink.LinkURL %></a><% end_if %>--%>
            <%--</{$TitleTagVariant}>--%>
            <%--<% end_if %>--%>

            <%--<% if $useSubtitle && $Subtitle %>--%>
                <%--<h3 class="card-subtitle">$Subtitle</h3>--%>
            <%--<% end_if %>--%>

            <%--<% if $Content %>--%>
                <%--<div class="card-text">--%>
                    <%--$Content--%>
                <%--</div>--%>
            <%--<% end_if %>--%>

            <%--<% if $ReadMoreLink.LinkURL %>--%>
                <%--<div class="element__readmorelink"><p><a href="$ReadMoreLink.LinkURL" class="{$ReadmoreLinkClass}" {$ReadMoreLink.TargetAttr} ><% if $ReadMoreLink.Title %>$ReadMoreLink.Title<% else %> mehr<% end_if %></a></p></div>--%>
            <%--<% end_if %>--%>
        <%--</div>--%>
    <%--</div>--%>
    <%--</div>--%>