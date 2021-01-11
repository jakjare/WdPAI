CREATE OR REPLACE PROCEDURE delete_user(
    id_user int
)
    LANGUAGE plpgsql
AS $$
DECLARE
    id_var_details integer;
BEGIN
    SELECT id_user_details INTO id_var_details FROM users WHERE id = id_user;
    DELETE FROM user_details WHERE id = id_var_details;
    COMMIT;

END; $$
