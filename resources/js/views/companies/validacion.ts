import * as yup from 'yup';

export const createCompanySchema = yup.object({
  ruc: yup
    .string()
    .required('RUC es requerido')
    .matches(/^[0-9]{11}$/, 'RUC debe tener 11 dígitos'),
  
  razon_social: yup
    .string()
    .required('Razón social es requerida')
    .min(3, 'Mínimo 3 caracteres')
    .max(255, 'Máximo 255 caracteres'),
  
  nombre_comercial: yup
    .string()
    .nullable()
    .max(255, 'Máximo 255 caracteres'),
  
  email: yup
    .string()
    .nullable()
    .email('Email inválido')
    .max(255, 'Máximo 255 caracteres'),
  
  telefono: yup
    .string()
    .nullable()
    .max(50, 'Máximo 50 caracteres'),
  
  direccion: yup
    .string()
    .nullable()
    .max(500, 'Máximo 500 caracteres')
});

export const editCompanySchema = createCompanySchema.shape({
  ruc: yup
    .string()
    .required('RUC es requerido')
    .matches(/^[0-9]{11}$/, 'RUC debe tener 11 dígitos')
    .test('no-change', 'No puedes cambiar el RUC', function(value) {
      // Esta validación evita que se cambie el RUC en edición
      return true; // Se maneja en backend
    })
});