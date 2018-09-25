<% if $ShowTitle %>
    <% include Derralf\\Elements\\ImageTeaser\\Title %>
<% end_if %>

<% if $HTML %>
    <div class="element__content">$HTML</div>
<% end_if %>

<% if $Teasers %>
    <div class="teaser-list image-teaser-list">
        <div class="row row-eq-height">
            <% loop $Teasers %>

                <% include Derralf\\Elements\\ImageTeaser\\Includes\\ElementImageTeaser_RoundedImage ColCss=col-sm-6 %>

            <% end_loop %>
        </div>
    </div>
<% end_if %>
