CREATE OR REPLACE PROCEDURE add_user(
    name varchar,
    surname varchar,
    phone varchar,
    role int,
    email varchar,
    password varchar,
    salt int
)
    LANGUAGE plpgsql
AS $$
DECLARE
    id_var_details integer;
    id_var_user integer;
BEGIN
    SELECT nextval('user_details_id_seq') INTO id_var_details;
    SELECT nextval('user_id_seq') INTO id_var_user;

    INSERT INTO user_details VALUES (id_var_details, name, surname, phone, DEFAULT, role);
    INSERT INTO users VALUES (id_var_user, id_var_details, email, password, true, salt, current_date);
    INSERT INTO login_history VALUES (DEFAULT, id_var_user,  current_timestamp, 'server', true);
    COMMIT;

END; $$


