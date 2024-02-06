<?php

namespace App\Enums\Widgets\SpaceCalculator;

use App\Enums\Contracts\HasLabel;

enum Asset: string implements HasLabel
{
    case PHONE_BOOTH = 'phone-booth';
    case OPEN_BOOTH = 'open-booth';
    case FOCUS_BOOTH = 'focus-booth';
    case CHILL_QUIET_SPACE = 'chill-quiet-space';
    case SCRUM_SPACE = 'scrum-space';
    case OPEN_COLLABORATION_TOUCHDOWN = 'open-collaboration-touchdown';
    case MEETING_BOOTH = 'meeting-booth';
    case WORKSHOP = 'workshop';
    case TWO_PERSON_INTERVIEW_OR_VC_ROOM = 'two-person-interview-or-vc-room';
    case FOUR_PERSON_MEETING_ROOM = 'four-person-meeting-room';
    case EIGHT_PERSON_MEETING_ROOM = 'eight-person-meeting-room';
    case TWELVE_PERSON_MEETING_ROOM = 'twelve-person-meeting-room';
    case SIXTEEN_PERSON_MEETING_ROOM = 'sixteen-person-meeting-room';
    case TWENTY_PERSON_MEETING_ROOM = 'twenty-person-meeting-room';
    case SERVERY = 'servery';
    case CATERING_KITCHEN_AND_STORES = 'catering-kitchens-and-stores';
    case CANTEEN_SEATING_SPACE = 'canteen-seating-space';
    case TEAPOINT = 'teapoint';
    case KITCHEN_AND_BAR = 'kitchen-and-bar';
    case GAMES_AREA = 'games-area';
    case GAMES_ROOM = 'games-room';
    case BREAKOUT_SEATS_OF_VARIOUS_TYPES = 'breakout-seats-of-various-types';

    /**
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::PHONE_BOOTH => 'Phone Booth',
            self::OPEN_BOOTH => 'Open Booth',
            self::FOCUS_BOOTH => 'Focus Booth',
            self::CHILL_QUIET_SPACE => 'Chill / Quiet Space',
            self::SCRUM_SPACE => 'Scrum Space',
            self::OPEN_COLLABORATION_TOUCHDOWN => 'Open Collaboration Touchdown',
            self::MEETING_BOOTH => 'Meeting Booth',
            self::WORKSHOP => 'Workshop',
            self::TWO_PERSON_INTERVIEW_OR_VC_ROOM => 'Two Person Interview or VC Room',
            self::FOUR_PERSON_MEETING_ROOM => 'Four Person Meeting Room',
            self::EIGHT_PERSON_MEETING_ROOM => 'Eight Person Meeting Room',
            self::TWELVE_PERSON_MEETING_ROOM => 'Twelve Person Meeting Room',
            self::SIXTEEN_PERSON_MEETING_ROOM => 'Sixteen Person Meeting Room',
            self::TWENTY_PERSON_MEETING_ROOM => 'Twenty Person Meeting Room',
            self::SERVERY => 'Servery',
            self::CATERING_KITCHEN_AND_STORES => 'Catering Kitchen and Stores',
            self::CANTEEN_SEATING_SPACE => 'Canteen Serving Space',
            self::TEAPOINT => 'Teapoint',
            self::KITCHEN_AND_BAR => 'Kitchen and Bar',
            self::GAMES_AREA => 'Games Area',
            self::GAMES_ROOM => 'Games Room',
            self::BREAKOUT_SEATS_OF_VARIOUS_TYPES => 'Breakout Seats of Various Types',
        };
    }

    /**
     * @return string
     */
    public function description(): string
    {
        return match ($this) {
            self::PHONE_BOOTH => 'Stand up or perch inside acoustic enclosure',
            self::OPEN_BOOTH => 'Open plan, semi enclosed booth, soft seat and table',
            self::FOCUS_BOOTH => 'Larger than a phone booth, smaller than a private office',
            self::CHILL_QUIET_SPACE => '"Phones off" room for quiet work or contemplation',
            self::SCRUM_SPACE => 'Semi open short-dwell meeting space with white board and screen',
            self::OPEN_COLLABORATION_TOUCHDOWN => 'Open seating designed for collaboration',
            self::MEETING_BOOTH => 'Semi enclosed, diner style booth',
            self::WORKSHOP => 'Enclosed space for prototyping, brainstorming, model making etc',
            self::TWO_PERSON_INTERVIEW_OR_VC_ROOM => 'Pod or built room',
            self::FOUR_PERSON_MEETING_ROOM, self::EIGHT_PERSON_MEETING_ROOM, self::TWELVE_PERSON_MEETING_ROOM,
            self::SIXTEEN_PERSON_MEETING_ROOM, self::TWENTY_PERSON_MEETING_ROOM => 'Back of house meeting room',
            self::SERVERY => 'Servery associated with a catered food offering',
            self::CATERING_KITCHEN_AND_STORES => 'Professional kitchen serving a canteen space',
            self::CANTEEN_SEATING_SPACE => 'Formal eating area associated with a catered food offering',
            self::TEAPOINT => 'Smaller run of units for self-service of drinks',
            self::KITCHEN_AND_BAR => 'Large kitchen and island unit for self-service of drinks, food prep etc',
            self::GAMES_AREA => 'Open or semi-open games area for pool, table tennis etc',
            self::GAMES_ROOM => 'Enclosed room for electronic games',
            self::BREAKOUT_SEATS_OF_VARIOUS_TYPES => 'General breakout areas with a mixture of seats and tables',
        };
    }

    /**
     * @return AreaType
     */
    public function areaType(): AreaType
    {
        return match ($this) {
            self::PHONE_BOOTH, self::OPEN_BOOTH, self::FOCUS_BOOTH, self::CHILL_QUIET_SPACE => AreaType::FOCUS,
            self::SCRUM_SPACE, self::OPEN_COLLABORATION_TOUCHDOWN, self::MEETING_BOOTH, self::WORKSHOP,
            self::TWO_PERSON_INTERVIEW_OR_VC_ROOM, self::FOUR_PERSON_MEETING_ROOM, self::EIGHT_PERSON_MEETING_ROOM,
            self::TWELVE_PERSON_MEETING_ROOM, self::SIXTEEN_PERSON_MEETING_ROOM,
            self::TWENTY_PERSON_MEETING_ROOM => AreaType::COLLABORATION,
            self::SERVERY, self::CATERING_KITCHEN_AND_STORES, self::CANTEEN_SEATING_SPACE, self::TEAPOINT,
            self::KITCHEN_AND_BAR, self::GAMES_AREA, self::GAMES_ROOM,
            self::BREAKOUT_SEATS_OF_VARIOUS_TYPES => AreaType::CONGREGATION_SPACE,
        };
    }

    /**
     * @return CapacityType|null
     */
    public function capacityType(): CapacityType|null
    {
        return match ($this) {
            self::SERVERY, self::CATERING_KITCHEN_AND_STORES, self::TEAPOINT, self::KITCHEN_AND_BAR => null,
            self::PHONE_BOOTH, self::OPEN_BOOTH, self::FOCUS_BOOTH,
            self::CHILL_QUIET_SPACE => CapacityType::FOCUS_SPACE,
            self::SCRUM_SPACE, self::OPEN_COLLABORATION_TOUCHDOWN, self::MEETING_BOOTH, self::WORKSHOP,
            self::TWO_PERSON_INTERVIEW_OR_VC_ROOM, self::FOUR_PERSON_MEETING_ROOM, self::EIGHT_PERSON_MEETING_ROOM,
            self::TWELVE_PERSON_MEETING_ROOM, self::SIXTEEN_PERSON_MEETING_ROOM,
            self::TWENTY_PERSON_MEETING_ROOM => CapacityType::TEAM_MEETING,
            self::CANTEEN_SEATING_SPACE, self::BREAKOUT_SEATS_OF_VARIOUS_TYPES => CapacityType::BREAKOUT,
            self::GAMES_AREA, self::GAMES_ROOM => CapacityType::RECREATION,
        };
    }
}
