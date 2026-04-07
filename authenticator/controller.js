export const authorizeRoles = (allowedRoles) => {
    return (req, res, next) => {
        const userRole = req.user.role; // Asumiendo que el rol del usuario está disponible en req.user
        if (!allowedRoles.includes(userRole)) {
            return res.status(403).json({ error: 'Acceso denegado' });
        }
        next();
    };
};
