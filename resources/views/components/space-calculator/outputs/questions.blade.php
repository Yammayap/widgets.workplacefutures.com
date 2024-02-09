<div>
    <h2>Questions and answers</h2>
    <ul> {{-- todo: discuss wording of this - perhaps defer until we have designs? (Trying to keep this short for now) --}}
        <li>
            Q1: Workstyle: {{ $inputs->workstyle->label() }}
        </li>
        <li>
            Q2: Total People: {{ $inputs->total_people }}
        </li>
        <li>
            Q3: Growth Percentage: {{ $inputs->growth_percentage }}
        </li>
        <li>
            Q4: Desk Percentage: {{ $inputs->desk_percentage }}
        </li>
        <li>
            Q5: Hybrid Working: {{ $inputs->hybrid_working->label() }}
        </li>
        <li>
            Q6: Mobility: {{ $inputs->mobility->label() }}
        </li>
        <li>
            Q7: Collaboration: {{ $inputs->collaboration->label() }}
        </li>
    </ul>
</div>