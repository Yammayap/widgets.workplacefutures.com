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
    case RECEPTION_DESK_POSITIONS = 'reception-desk-positions';
    case RECEPTION_WAITING_AREA_SEATS = 'reception-waiting-area-seats';
    case RECEPTION_STORAGE = 'reception-storage';
    case FURNITURE_STORE = 'furniture-store';
    case FRONT_OF_HOUSE_KITCHEN = 'front-of-house-kitchen';
    case TWO_PERSON_INTERVIEW_ROOM = 'two-person-interview-room';
    case FOUR_PERSON_CONFERENCE_ROOM = 'four-person-conference-room';
    case EIGHT_PERSON_CONFERENCE_ROOM = 'eight-person-conference-room';
    case TWELVE_PERSON_CONFERENCE_ROOM = 'twelve-person-conference-room';
    case SIXTEEN_PERSON_CONFERENCE_ROOM = 'sixteen-person-conference-room';
    case TWENTY_PERSON_CONFERENCE_ROOM = 'twenty-person-conference-room';
    case FIFTY_PERSON_CONFERENCE_ROOM = 'fifty-person-conference-room';
    case MAIN_EQUIPMENT_ROOM = 'main-equipment-room';
    case COMMS_ROOM_OR_SER = 'comms-room-or-ser';
    case IT_BUILD_ROOM = 'it-build-room';
    case PRINT_AND_COPY_AREA = 'print-and-copy-area';
    case STATIONARY_STORE = 'stationary-store';
    case FACILITIES_STORE = 'facilities-store';
    case COAT_STORAGE = 'coat-storage';
    case CLEANERS_CUPBOARD = 'cleaners-cupboard';
    case PRAYER_ROOM = 'prayer-room';
    case FOUR_HIGH_LOCKERS = 'four-high-lockers';
    case GYM = 'gym';
    case STUDIO = 'studio';
    case SHOWERS_AND_CHANGING_AREA = 'showers-and-changing-area';

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
            self::RECEPTION_DESK_POSITIONS => 'Reception Desk Positions',
            self::RECEPTION_WAITING_AREA_SEATS => 'Reception Waiting Area Seats',
            self::RECEPTION_STORAGE => 'Reception Storage',
            self::FURNITURE_STORE => 'Furniture Store',
            self::FRONT_OF_HOUSE_KITCHEN => 'Front of House Kitchen',
            self::TWO_PERSON_INTERVIEW_ROOM => 'Two Person Interview Room',
            self::FOUR_PERSON_CONFERENCE_ROOM => 'Four Person Conference Room',
            self::EIGHT_PERSON_CONFERENCE_ROOM => 'Eight Person Conference Room',
            self::TWELVE_PERSON_CONFERENCE_ROOM => 'Twelve Person Conference Room',
            self::SIXTEEN_PERSON_CONFERENCE_ROOM => 'Sixteen Person Conference Room',
            self::TWENTY_PERSON_CONFERENCE_ROOM => 'Twenty Person Conference Room',
            self::FIFTY_PERSON_CONFERENCE_ROOM => 'Fifty Person Conference Room',
            self::MAIN_EQUIPMENT_ROOM => 'Main Equipment Room (MER)',
            self::COMMS_ROOM_OR_SER => 'Comms Room or SER',
            self::IT_BUILD_ROOM => 'IT Build Room',
            self::PRINT_AND_COPY_AREA => 'Print and Copy Area',
            self::STATIONARY_STORE => 'Stationary Store',
            self::FACILITIES_STORE => 'Facilities Store',
            self::COAT_STORAGE => 'Coat Storage',
            self::CLEANERS_CUPBOARD => 'Cleaner\'s Cupboard',
            self::PRAYER_ROOM => 'Prayer Room',
            self::FOUR_HIGH_LOCKERS => 'Four High Lockers',
            self::GYM => 'Gym',
            self::STUDIO => 'Studio',
            self::SHOWERS_AND_CHANGING_AREA => 'Shower and Changing Area',
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
            self::RECEPTION_DESK_POSITIONS => 'Reception desk with a variable number of receptionists',
            self::RECEPTION_WAITING_AREA_SEATS => 'Waiting area arranged in clusters',
            self::RECEPTION_STORAGE => 'Room for post, parcels, coats and luggage',
            self::FURNITURE_STORE => 'Store room for reconfigurable spaces such as seminar rooms',
            self::FRONT_OF_HOUSE_KITCHEN => 'Food and beverage preparation area',
            self::TWO_PERSON_INTERVIEW_ROOM => '2 person interview room for vendors, recruits etc',
            self::FOUR_PERSON_CONFERENCE_ROOM => '4 person front of house meeting room',
            self::EIGHT_PERSON_CONFERENCE_ROOM => '8 person front of house meeting room',
            self::TWELVE_PERSON_CONFERENCE_ROOM => '12 person front of house meeting room',
            self::SIXTEEN_PERSON_CONFERENCE_ROOM => '16 person front of house meeting room',
            self::TWENTY_PERSON_CONFERENCE_ROOM => '20 person front of house meeting room',
            self::FIFTY_PERSON_CONFERENCE_ROOM => '50 person front of house meeting room',
            self::MAIN_EQUIPMENT_ROOM => 'Comms room capable of taking up to 5 racks',
            self::COMMS_ROOM_OR_SER => 'Comms room for up to 2 racks for smaller offices, patching or SER',
            self::IT_BUILD_ROOM => 'Enclosed room for building out IT equipment including store',
            self::PRINT_AND_COPY_AREA => 'Open or semi-open area with a multifunction device and paper storage',
            self::STATIONARY_STORE => 'Room or set of cupboards for stationery',
            self::FACILITIES_STORE => 'Enclosed room for general facilities use such as consumables',
            self::COAT_STORAGE => 'Cupboard for 10 workers\' coats',
            self::CLEANERS_CUPBOARD => 'Enclosed room suitable for housing cleaning equipment',
            self::PRAYER_ROOM => 'Enclosed room that may double as a mother\'s and lying down room',
            self::FOUR_HIGH_LOCKERS => 'Bank of 4-high lockers sufficient for number of open workstations',
            self::GYM => 'Enclosed room of sufficient size for general cardio equipment, mats, small weights',
            self::STUDIO => 'Enclosed room for general relaxation, yoga etc',
            self::SHOWERS_AND_CHANGING_AREA => 'Additional showers and changing area to serve a gym',
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

            self::RECEPTION_DESK_POSITIONS, self::RECEPTION_WAITING_AREA_SEATS, self::RECEPTION_STORAGE,
            self::FURNITURE_STORE, self::FRONT_OF_HOUSE_KITCHEN, self::TWO_PERSON_INTERVIEW_ROOM,
            self::FOUR_PERSON_CONFERENCE_ROOM, self::EIGHT_PERSON_CONFERENCE_ROOM, self::TWELVE_PERSON_CONFERENCE_ROOM,
            self::SIXTEEN_PERSON_CONFERENCE_ROOM, self::TWENTY_PERSON_CONFERENCE_ROOM,
            self::FIFTY_PERSON_CONFERENCE_ROOM => AreaType::FRONT_OF_HOUSE,

            self::MAIN_EQUIPMENT_ROOM, self::COMMS_ROOM_OR_SER, self::IT_BUILD_ROOM, self::PRINT_AND_COPY_AREA,
            self::STATIONARY_STORE, self::FACILITIES_STORE, self::COAT_STORAGE, self::CLEANERS_CUPBOARD,
            self::PRAYER_ROOM, self::FOUR_HIGH_LOCKERS, self::GYM, self::STUDIO,
            self::SHOWERS_AND_CHANGING_AREA => AreaType::FACILITIES,
        };
    }

    /**
     * @return CapacityType|null
     */
    public function capacityType(): CapacityType|null
    {
        return match ($this) {
            self::SERVERY, self::CATERING_KITCHEN_AND_STORES, self::TEAPOINT, self::KITCHEN_AND_BAR,
            self::RECEPTION_WAITING_AREA_SEATS, self::RECEPTION_STORAGE, self::FURNITURE_STORE,
            self::FRONT_OF_HOUSE_KITCHEN, self::MAIN_EQUIPMENT_ROOM, self::COMMS_ROOM_OR_SER, self::IT_BUILD_ROOM,
            self::PRINT_AND_COPY_AREA, self::STATIONARY_STORE, self::FACILITIES_STORE, self::COAT_STORAGE,
            self::CLEANERS_CUPBOARD, self::PRAYER_ROOM, self::FOUR_HIGH_LOCKERS,
            self::SHOWERS_AND_CHANGING_AREA => null,

            self::PHONE_BOOTH, self::OPEN_BOOTH, self::FOCUS_BOOTH,
            self::CHILL_QUIET_SPACE => CapacityType::FOCUS_SPACE,

            self::SCRUM_SPACE, self::OPEN_COLLABORATION_TOUCHDOWN, self::MEETING_BOOTH, self::WORKSHOP,
            self::TWO_PERSON_INTERVIEW_OR_VC_ROOM, self::FOUR_PERSON_MEETING_ROOM, self::EIGHT_PERSON_MEETING_ROOM,
            self::TWELVE_PERSON_MEETING_ROOM, self::SIXTEEN_PERSON_MEETING_ROOM,
            self::TWENTY_PERSON_MEETING_ROOM => CapacityType::TEAM_MEETING,

            self::CANTEEN_SEATING_SPACE, self::BREAKOUT_SEATS_OF_VARIOUS_TYPES => CapacityType::BREAKOUT,

            self::GAMES_AREA, self::GAMES_ROOM, self::GYM, self::STUDIO => CapacityType::RECREATION,

            self::RECEPTION_DESK_POSITIONS => CapacityType::LONG_DWELL_WORKSTATION,

            self::TWO_PERSON_INTERVIEW_ROOM, self::FOUR_PERSON_CONFERENCE_ROOM, self::EIGHT_PERSON_CONFERENCE_ROOM,
            self::TWELVE_PERSON_CONFERENCE_ROOM, self::SIXTEEN_PERSON_CONFERENCE_ROOM,
            self::TWENTY_PERSON_CONFERENCE_ROOM, self::FIFTY_PERSON_CONFERENCE_ROOM => CapacityType::FRONT_OF_HOUSE,
        };
    }
}
