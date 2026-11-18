
PRAGMA foreign_keys = ON;

DELETE FROM review;
DELETE FROM follow;
DELETE FROM food_item;
DELETE FROM premium_membership;
DELETE FROM restaurants;
DELETE FROM users;

-- make 1 and 2 the test users 
INSERT INTO users (user_id, first_name, last_name, email, password_hash, role, created_at) VALUES
    (3, 'Emma',  'Reviewer', 'emma@example.com',  '$2y$12$VsVpQkBA2.8xCsf4YVaqiutGB7VPMUzb7paMSSCufj.sEHZCyqNfq', 'Member', '2026-09-01 10:00:00'),
    (4, 'Scott', 'Reviewer', 'scott@example.com', '$2y$12$VsVpQkBA2.8xCsf4YVaqiutGB7VPMUzb7paMSSCufj.sEHZCyqNfq', 'Member', '2026-09-01 10:00:00'),
    (5, 'Nick',  'Reviewer', 'nick@example.com',  '$2y$12$VsVpQkBA2.8xCsf4YVaqiutGB7VPMUzb7paMSSCufj.sEHZCyqNfq', 'Member', '2026-09-01 10:00:00');

INSERT INTO restaurants (membership_id, restaurant_id, name, cuisine_type, price_range, address, city, phone, avg_rating, created_at) VALUES
    (1, 1, 'Olive & Ember',             'Italian', '$$',  '101 Main St',   'Salt Lake City', '801-555-0101', 4.8, '2026-08-01 09:00:00'),
    (2, 2, 'Juniper Street Tacos',      'Mexican', '$',   '202 Juniper St', 'Salt Lake City', '801-555-0102', 4.6, '2026-08-01 09:00:00'),
    (3, 3, 'Harborlight Kitchen',       'Seafood', '$$$', '303 Harbor Way', 'Salt Lake City', '801-555-0103', 4.4, '2026-08-01 09:00:00'),
    (4, 4, 'Maple & Main Brunch House', 'Brunch',  '$$',  '404 Maple Ave',  'Salt Lake City', '801-555-0104', 4.7, '2026-08-01 09:00:00'),
    (5, 5, 'Cedar Bowl Noodle Bar',     'Noodles', '$$',  '505 Cedar Blvd', 'Salt Lake City', '801-555-0105', 4.5, '2026-08-01 09:00:00');

INSERT INTO food_item (food_item_id, restaurant_id, name, description, price, category) VALUES
    (1,  1, 'Cacio e Pepe',             'Handmade pasta with pecorino and black pepper.', 18.00, 'Entree'),
    (2,  1, 'Wood-Fired Margherita',    'Tomato, mozzarella and basil.',                  16.00, 'Entree'),
    (3,  1, 'Tiramisu',                 'Espresso-soaked ladyfingers and mascarpone.',     9.00, 'Dessert'),
    (4,  2, 'Roasted Mushroom Tacos',   'Roasted mushrooms with salsa verde.',             4.50, 'Entree'),
    (5,  2, 'Carnitas Tacos',           'Slow-braised pork with onion and cilantro.',      4.50, 'Entree'),
    (6,  2, 'Elote',                    'Grilled street corn with cotija.',                5.00, 'Side'),
    (7,  3, 'Crispy Fish Sandwich',     'Fried fish with slaw on a brioche bun.',         17.00, 'Entree'),
    (8,  3, 'Clam Chowder',             'Creamy New England-style chowder.',               9.00, 'Soup'),
    (9,  3, 'Catch of the Day',         'Daily fresh catch, market preparation.',         29.00, 'Entree'),
    (10, 4, 'Blueberry Pancakes',       'Fluffy pancakes with blueberries and syrup.',    13.00, 'Breakfast'),
    (11, 4, 'Breakfast Bowl',           'Potatoes, eggs, vegetables and cheese.',         14.00, 'Breakfast'),
    (12, 4, 'House Latte',              'Locally roasted espresso with steamed milk.',     5.50, 'Drink'),
    (13, 5, 'Spicy Miso Ramen',         'Rich miso broth with chili oil.',                16.00, 'Entree'),
    (14, 5, 'Hand-Pulled Beef Noodles', 'Hand-pulled noodles in beef broth.',             17.00, 'Entree'),
    (15, 5, 'Veggie Udon',              'Thick udon with seasonal vegetables.',           14.00, 'Entree');


INSERT INTO review (review_id, user_id, food_item_id, rating, comment, created_at, updated_at) VALUES
    (1, 3, 1,  5, 'Perfectly peppery and silky. Easily the best pasta I have had in town.', '2026-10-22 12:00:00', '2026-10-22 12:00:00'),
    (2, 4, 3,  4, 'Light and not too sweet. Would order again.',                             '2026-10-09 12:00:00', '2026-10-09 12:00:00'),
    (3, 5, 4,  5, 'Fresh tortillas and bright salsa made this a great lunch.',               '2026-10-18 12:00:00', '2026-10-18 12:00:00'),
    (4, 4, 7,  4, 'Crunchy, flaky, and generous. The patio view is a bonus.',                '2026-09-30 12:00:00', '2026-09-30 12:00:00'),
    (5, 3, 10, 4, 'Relaxed atmosphere, generous portions, and excellent coffee.',            '2026-09-29 12:00:00', '2026-09-29 12:00:00'),
    (6, 5, 13, 5, 'Rich broth with real heat. The noodles had a great chew.',                '2026-10-02 12:00:00', '2026-10-02 12:00:00');

-- this should be changed to a test user
INSERT INTO follow (user_id, restaurant_id, followed_at) VALUES
    (3, 1, '2026-09-05 12:00:00'),
    (3, 3, '2026-09-05 12:00:00'),
    (3, 5, '2026-09-05 12:00:00');
