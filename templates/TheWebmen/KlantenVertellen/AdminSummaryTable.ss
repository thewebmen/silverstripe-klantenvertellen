<table class="table">
    <tr>
        <th>Gemiddelde</th>
        <td style="width: 95%">$Avarage</td>
    </tr>
    <tr>
        <th>Aantal reviews</th>
        <td style="width: 95%">$NumReviews</td>
    </tr>
    <tr>
        <th>Aanbevelingspercentage</th>
        <td style="width: 95%">$PercentageRecommend</td>
    </tr>
    <% loop $GradesList %>
        <tr>
            <th>
                $Title
            </th>
            <td style="width: 95%">
                $Grade
            </td>
        </tr>
    <% end_loop %>
</table>
