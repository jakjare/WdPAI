create view user_full
            (id, email, password, enabled, salt, created_at, name, surname, phone, image, description, date) as
SELECT users.id,
       users.email,
       users.password,
       users.enabled,
       users.salt,
       users.created_at,
       user_details.name,
       user_details.surname,
       user_details.phone,
       user_details.image,
       roles.description,
       history.date
FROM users
         LEFT JOIN user_details ON users.id_user_details = user_details.id
         LEFT JOIN roles ON roles.id = user_details.role
         LEFT JOIN (SELECT login_history.id_user,
                           max(login_history.date) AS date
                    FROM login_history
                    GROUP BY login_history.id_user) history ON users.id = history.id_user;

alter table user_full
    owner to admingate_user;

