import { useEffect } from "react";
import { Col, Container, Row } from "react-bootstrap";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import { setToast } from "../../../store/toastSlice";
import List from "./List";
import Upload from "./Upload";
function AdminDashboard() {
  const user = useSelector((state) => state.auth.login.currentUser);
  const navigate = useNavigate();
  const dispatch = useDispatch();
  useEffect(() => {
    if (!user || user.role !== "admin") {
      dispatch(setToast({ message: "Bạn không có quyền truy cập.", type: "warning" }));
      navigate("/");
    }
  }, [user]);

  return (
    <Container className="mt-5">
      <Row>
        <Col xs={12} lg={4}>
          <Upload />
        </Col>
        <Col xs={12} lg={8}>
          <List />
        </Col>
      </Row>
    </Container>
  );
}

export default AdminDashboard;
