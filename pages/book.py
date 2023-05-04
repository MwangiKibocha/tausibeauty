import datetime
from typing import List

class Stylist:
    def __init__(self, id: int, name: str) -> None:
        self.id = id
        self.name = name

class Booking:
    def __init__(self, stylist_id: int, datetime: datetime.datetime) -> None:
        self.stylist_id = stylist_id
        self.datetime = datetime

class BookingSystem:
    def __init__(self) -> None:
        self.stylists = [
            Stylist(1, 'John'),
            Stylist(2, 'Jane'),
            Stylist(3, 'Mike'),
            Stylist(4, 'Emily'),
        ]
        self.bookings = []

    def is_stylist_available(self, stylist_id: int, datetime: datetime.datetime) -> bool:
        for booking in self.bookings:
            if booking.stylist_id == stylist_id and booking.datetime == datetime:
                return False
        return True

    def get_available_stylists(self, datetime: datetime.datetime) -> List[Stylist]:
        available_stylists = []
        for stylist in self.stylists:
            if self.is_stylist_available(stylist.id, datetime):
                available_stylists.append(stylist)
        return available_stylists

    def book_stylist(self, stylist_id: int, datetime: datetime.datetime) -> None:
        if not self.is_stylist_available(stylist_id, datetime):
            raise Exception('Stylist not available')
        self.bookings.append(Booking(stylist_id, datetime))
        print(f'Stylist {stylist_id} booked for {datetime}')

booking_system = BookingSystem()

# Example usage:
selected_datetime = datetime.datetime(2023, 3, 10, 14, 0)
available_stylists = booking_system.get_available_stylists(selected_datetime)

if available_stylists:
    print('Available stylists:')
    for stylist in available_stylists:
        print(f'- {stylist.name}')
    selected_stylist_id = int(input('Enter the ID of the stylist you want to book: '))
    booking_system.book_stylist(selected_stylist_id, selected_datetime)
else:
    print('No available stylists')
