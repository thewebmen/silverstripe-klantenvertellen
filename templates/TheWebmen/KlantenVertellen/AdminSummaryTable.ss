<table class="table">
    <tr>
        <th>Gemiddelde</th>
        <td>$Avarage</td>
    </tr>
    <tr>
        <th>Aantal reviews</th>
        <td>$NumReviews</td>
    </tr>
    <tr>
        <th>Aanbevelingspercentage</th>
        <td>$PercentageRecommend</td>
    </tr>
    <% loop $GradesList %>
        <tr>
            <th>
                $Title
            </th>
            <td>
                $Grade
            </td>
        </tr>
    <% end_loop %>
</table>
