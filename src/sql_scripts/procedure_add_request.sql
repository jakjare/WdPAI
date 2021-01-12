CREATE OR REPLACE PROCEDURE add_request(
    id_sender int,
    id_device int,
    topic varchar,
    content varchar,
    important bool,
    receivers int[]
)
    LANGUAGE plpgsql
AS $$
DECLARE
    id_var_request integer;
    id_user integer;
BEGIN
    SELECT nextval('request_id_seq') INTO id_var_request;

    INSERT INTO requests VALUES (id_var_request, id_sender, id_device, topic, content, default, default, important, default);

    FOREACH id_user IN ARRAY receivers
        LOOP
            INSERT INTO request_receiver VALUES (id_var_request, id_user);
        END LOOP;

    COMMIT;

END; $$