
<div class="{$ColCss} mb-4">
    <div class="card h-100 {$Style}" data-mh="card-teaser-{$TeaserHolderID}">
        <% if $Image && $ShowImage %>
            <% if $ReadMoreLink.LinkURL %><a href="$ReadMoreLink.LinkURL" title="$ReadMoreLinkTitle.ATT" {$ReadMoreLink.TargetAttr} ><% end_if %>
            <img class="rounded-circle img-fluid centered" src="$Image.FocusFillMax(260,260).Link" alt="$Image.Title.ATT">
            <% if $ReadMoreLink.LinkURL %></a><% end_if %>
        <% end_if %>
        <div class="card-body">
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
        </div>
    </div>
</div>
