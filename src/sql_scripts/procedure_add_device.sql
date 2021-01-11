CREATE OR REPLACE PROCEDURE add_device(
    name varchar,
    ip_address varchar,
    comment varchar,
    id_location int,
    permission int[]
)
    LANGUAGE plpgsql
AS $$
DECLARE
    id_var_device integer;
    id_user integer;
BEGIN
    SELECT nextval('devices_id_seq') INTO id_var_device;

    INSERT INTO devices VALUES (id_var_device, name, ip_address, comment, id_location, default, default);

    FOREACH id_user IN ARRAY permission
        LOOP
            INSERT INTO user_device VALUES (id_user, id_var_device);
        END LOOP;

    COMMIT;

END; $$