## Assumptions

1. Based on Challenge split tables into "doctors" and "clinics". 
2. create "hasMany" and "belongsTo" relationships between doctros and clinics.
3. Fix the tests page list by changing doctor relations to clinic and changed in seeder classes.
4. Create a button to get Duplicate doctors and clinics on doctors list page.
5. By clicking on the "Find Duplicate Doctors" or "Find Duplicate Clinics", it will show duplicate records in existing tables.
6. The "Find Duplicate Doctors" page presents a list of duplicate doctor records with same name and specialty, accompanied by a "Merge Duplicate Records" button positioned at the top of the list. Upon clicking the button, the system initiates a query on the "tests" table to identify any records marked for deletion that reference the duplicate doctors. Subsequently, it updates these records, substituting the referring doctor ID with the ID of the doctor intended for retention, thereby preserving data integrity. Following the update process, the system removes the duplicate doctor records from the database, leaving behind only the merged records with updated references.
6. The "Find Duplicate Clinics" page presents a list of duplicate clinic records with same name and address, accompanied by a "Merge Duplicate Records" button positioned at the top of the list. Upon clicking the button, the system initiates a query on the "doctors" table to identify any records marked for deletion that reference the duplicate clinics. Subsequently, it updates these records, substituting the clinic ID with the ID of the clinic intended for retention, thereby preserving data integrity. Following the update process, the system removes the duplicate clinic records from the database, leaving behind only the merged records with updated references.


