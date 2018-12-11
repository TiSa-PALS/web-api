CREATE VIEW v_print AS
  select CONCAT(concat(t.label, LPAD(i.id_number, 3, '0')), '/', i.EUIN) as `bar_code`,
         ''                                                              as link,
         i.EUIN,
         concat(t.label, LPAD(i.id_number, 3, '0'))                      as `identificator`,
         CONCAT(
           IF(p.size is not NULL, CONCAT(p.size, ' ;'), ''),
           IF(
             p.size_diameter is not NULL,
             CONCAT('D=', p.size_diameter, ' ;'),
             ''),
           IF(p.thickness is not NULL, CONCAT(p.thickness, 'mm ;'), ''),
           IF(p.coating is not NULL, CONCAT(p.coating, ';'), ''),
           IF(p.material is not NULL, CONCAT(p.material, ' ;'), ''),
           IF(p.surface_type is not NULL, CONCAT(p.surface_type, ' ;'), ''),
           IF(
             p.wavelength_from is not NULL AND p.wavelength_to is not NULL,
             CONCAT(p.wavelength_from, '-', p.wavelength_to, ';'),
             ''),
           IF(p.wavelength_note is not NULL, CONCAT(p.wavelength_note, ';'), ''),
           IF(p.incidence_angle is not NULL, CONCAT(p.incidence_angle, '°;'), ''),
           IF(
             p.length_difference is not NULL,
             CONCAT(p.length_difference, 'λ;'),
             ''),
           IF(
             p.transmission_wavelength is not NULL,
             CONCAT(p.transmission_wavelength, ' nm;'),
             ''),
           IF(p.transmission is not NULL, CONCAT(p.transmission, ';'), ''),
           IF(p.optical_density is not NULL, CONCAT(p.optical_density, ';'), ''),
           IF(p.angle is not NULL, CONCAT(p.angle, '°;'), ''),
           IF(
             p.angle_tolerance is not NULL,
             CONCAT(p.angle_tolerance, 'mdeg;'),
             ''),
           IF(p.reflectivity is not NULL, CONCAT(p.reflectivity, ';'), ''),
           IF(p.focus is not NULL, CONCAT('f=', p.focus, 'mm ;'), ''),
           IF(
             p.filter_thickness IS NOT NULL,
             CONCAT(p.filter_thickness, ' nm ;'),
             ''),
           IF(p.polarization is not NULL, CONCAT(p.polarization, ';'), ''),
           IF(p.surface is not NULL, CONCAT(p.surface, ';'), '')
             )                                                           as `summary`,
         g.name                                                          as `grant`
  from item i
         join product p using (product_id)
         join type t on p.type_id = t.type_id
         join `grant` g using (grant_id)
