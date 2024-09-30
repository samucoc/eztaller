import React from 'react';
import {
  Container,
  Grid,
  Card,
  CardContent,
  Typography,
  TextField,
  Button,
  Alert,
  CircularProgress,
} from '@mui/material';

const Login = ({ username, password, loading, error, setUsername, setPassword, handleSubmit }) => {
  return (
    <Container maxWidth="sm">
      <Grid container justifyContent="center" style={{ marginTop: '5rem' }}>
        <Grid item xs={12}>
          <Card>
            <CardContent>
              <div style={{ textAlign: 'center', marginBottom: '2rem' }}>
                <img src="logo.png" alt="Logo" style={{ maxWidth: '100%', height: 'auto' }} />
                <br />
                <br />
                
              </div>
              <form onSubmit={handleSubmit}>
                <TextField
                  label="Nombre de Usuario"
                  variant="outlined"
                  fullWidth
                  margin="normal"
                  value={username}
                  onChange={(e) => setUsername(e.target.value)}
                  InputProps={{
                    style: { color: 'black' }  // Text color inside the input
                  }}
                  InputLabelProps={{
                    style: { color: 'black' }  // Label color
                  }}
                />
                <TextField
                  label="Contraseña"
                  type="password"
                  variant="outlined"
                  fullWidth
                  margin="normal"
                  value={password}
                  onChange={(e) => setPassword(e.target.value)}
                  InputProps={{
                    style: { color: 'black' }  // Text color inside the input
                  }}
                  InputLabelProps={{
                    style: { color: 'black' }  // Label color
                  }}
                />
                <Button
                  type="submit"
                  variant="contained"
                  color="primary"
                  fullWidth
                  disabled={loading}
                  startIcon={loading && <CircularProgress size={20} />}
                  style={{ marginTop: '1rem' }}
                >
                  {loading ? 'Cargando...' : 'Iniciar Sesión'}
                </Button>
                {error && <Alert severity="error" style={{ marginTop: '1rem' }}>{error}</Alert>}
              </form>
            </CardContent>
          </Card>
        </Grid>
      </Grid>
    </Container>
  );
};

export default Login;
