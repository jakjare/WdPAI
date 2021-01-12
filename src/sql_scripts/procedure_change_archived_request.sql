CREATE OR REPLACE PROCEDURE change_archived_request(
    id_request int
)
    LANGUAGE plpgsql
AS $$
DECLARE
    current_status bool;
BEGIN
    SELECT archived INTO current_status FROM requests WHERE id = id_request;
    UPDATE requests SET archived = NOT(current_status) WHERE id = id_request;
    COMMIT;

END; $$